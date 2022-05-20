using HttpServer.Enums;
using System;
using System.Collections.Generic;
using System.Linq;

namespace HttpServer.Models
{
    internal class HttpRequest
    {
        public HttpMethod Method { get; set; }
        public string Url { get; set; }
        public string Path { get; set; }
        public string Content { get; set; }
        public Route Route { get; set; }
        public Dictionary<string, string> Headers { get; set; }

        public HttpRequest()
        {
            Headers = new Dictionary<string, string>();
        }

        public override string ToString()
        {
            if (!String.IsNullOrWhiteSpace(Content))
            {
                if (!Headers.ContainsKey("Content-Length"))
                {
                    Headers.Add("Content-Length", Content.Length.ToString());
                }
            }
            return $"{Method} {Url} HTTP/1.0\r\n{string.Join("\r\n", Headers.Select(x => string.Format("{0}: {1}", x.Key, x.Value)))}\r\n\r\n{Content}";
        }
    }
}
