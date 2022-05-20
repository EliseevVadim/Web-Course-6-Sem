﻿using HttpServer.Attributes;
using HttpServer.Enums;
using HttpServer.Models;
using Newtonsoft.Json;
using Newtonsoft.Json.Linq;
using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Net.Sockets;
using System.Reflection;
using System.Text;
using System.Text.RegularExpressions;

namespace HttpServer.Core
{
    internal class HttpProcessor
    {
        private List<Route> _routes = new List<Route>();

        public void HandleClient(TcpClient client)
        {
            NetworkStream inputStream = GetInputStream(client);
            NetworkStream outputStream = GetOutputStram(client);
            HttpRequest request = GetRequest(inputStream, outputStream);
            HttpResponse response = ProcessRequest(request);
            Console.WriteLine($"{response.StatusCode} - {request.Url}");
            WriteResponse(outputStream, response);
            outputStream.Flush();
            outputStream.Close();
            outputStream = null;
            inputStream.Close();
            inputStream = null;
        }

        public void AddRoute(Route addition)
        {
            _routes.Add(addition);
        }

        protected virtual NetworkStream GetInputStream(TcpClient client)
        {
            return client.GetStream();
        }

        protected virtual NetworkStream GetOutputStram(TcpClient client)
        {
            return client.GetStream();
        }

        protected virtual HttpResponse ProcessRequest(HttpRequest request)
        {
            List<Route> correspondingRoutes = _routes.Where(route => Regex.Match(request.Url, route.Url).Success).ToList();
            Route requestedRoute = correspondingRoutes.SingleOrDefault(route => route.Method == request.Method);
            if (requestedRoute == null)
                return new HttpResponse
                {
                    Description = "Method not allowed",
                    StatusCode = HttpStatusCode.MethodNotAllowed
                };
            Assembly currentProjectAssembly = Assembly.GetExecutingAssembly();
            var controllers = currentProjectAssembly.GetTypes()
                .Where(type => type.GetCustomAttributes(typeof(Controller), true).Any())
                .ToList();
            MethodInfo correctMethod = null;
            Type correctController = null;
            foreach (var controller in controllers)
            {
                var controllerMethods = controller.GetMethods()
                    .Where(method => method.GetCustomAttributes(typeof(Page)).Any());
                correctMethod = controllerMethods
                    .Where(method => method.GetCustomAttributes(typeof(Page)).FirstOrDefault() is Page page && page.Uri == request.Url)
                    .FirstOrDefault();
                if (correctMethod != null)
                {
                    correctController = controller;
                }
            }
            if (correctMethod == null)
                return new HttpResponse
                {
                    StatusCode = HttpStatusCode.NotFound,
                    Description = "Method not found"
                };
            try
            {
                string[] urlParams = request.Url.Split('/');
                List<object> methodParams = new List<object>();
                foreach (string param in urlParams)
                {
                    int temp;
                    if (int.TryParse(param, out temp))
                    {
                        methodParams.Add(int.Parse(param));
                    }
                }
                JObject methodOutput = (JObject)correctMethod.Invoke(correctController, methodParams.ToArray());
                string jsonOutput = methodOutput.ToString(Formatting.Indented);
                return new HttpResponse()
                {
                    StatusCode = HttpStatusCode.Ok,
                    Description = "success",
                    ContentInUtf8 = jsonOutput
                };
            }
            catch (Exception ex)
            {
                return new HttpResponse()
                {
                    StatusCode = HttpStatusCode.InternalServerError,
                    Description = ex.Message
                };
            }
        }

        private static string ReadRequestLine(NetworkStream inputStream)
        {
            BinaryReader reader = new BinaryReader(inputStream);
            string requestLine = string.Empty;
            char ch;
            while ((int)(ch = reader.ReadChar()) != '\n')
            {
                requestLine += ch;
            }
            return requestLine;
        }

        private static void WriteResponse(NetworkStream stream, HttpResponse response)
        {
            if (response.Content == null)
                response.Content = new byte[] { };
            if (!response.Headers.ContainsKey("Content-Type"))
                response.Headers["Content-Type"] = "application/json";
            response.Headers["Content-Length"] = response.Content.Length.ToString();
            WriteTextContentToStream(stream, $"HTTP/1.0 {response.StatusCode} {response.Description}\r\n");
            WriteTextContentToStream(stream, string.Join("\r\n", response.Headers.Select(header => $"{header.Key} : {header.Value}")));
            WriteTextContentToStream(stream, "\r\n\r\n");
            stream.Write(response.Content, 0, response.Content.Length);
        }

        private static void WriteTextContentToStream(NetworkStream stream, string content)
        {
            byte[] raw = Encoding.UTF8.GetBytes(content);
            stream.Write(raw, 0, raw.Length);
        }

        private HttpRequest GetRequest(NetworkStream inputStream, NetworkStream outputStream)
        {
            string requestLine = ReadRequestLine(inputStream);
            string[] tokens = requestLine.Split(' ');
            Console.WriteLine(requestLine);
            if (tokens.Length != 3)
                throw new Exception("Invalid request line.");
            HttpMethod method = (HttpMethod)Enum.Parse(typeof(HttpMethod), tokens[0].ToUpper());
            string url = tokens[1];
            string apiVersion = tokens[2];
            Dictionary<string, string> headers = new Dictionary<string, string>();
            string line;
            while (!String.IsNullOrWhiteSpace(line = ReadRequestLine(inputStream)))
            {
                int separatorIndex = line.IndexOf(":");
                if (separatorIndex == -1)
                    throw new Exception($"Invalid header definition in line: {line}");
                string name = line.Substring(0, separatorIndex);
                int currentIndex = separatorIndex + 1;
                while ((currentIndex < line.Length) && (line[currentIndex] == ' '))
                {
                    currentIndex++;
                }
                string value = line.Substring(currentIndex, line.Length - currentIndex);
                headers.Add(name, value);
            }
            string content = null;
            if (headers.ContainsKey("Content-Length"))
            {
                int totalBytes = int.Parse(headers["Content-Length"]);
                int bytesLeft = totalBytes;
                byte[] bytes = new byte[totalBytes];
                while (bytesLeft > 0)
                {
                    byte[] buffer = new byte[bytesLeft > 1024 ? 1024 : bytesLeft];
                    int n = inputStream.Read(buffer, 0, buffer.Length);
                    buffer.CopyTo(bytes, totalBytes - bytesLeft);
                    bytesLeft -= n;
                }
                content = Encoding.ASCII.GetString(bytes);
            }
            return new HttpRequest
            {
                Method = method,
                Headers = headers,
                Url = url,
                Content = content
            };
        }
    }
}
