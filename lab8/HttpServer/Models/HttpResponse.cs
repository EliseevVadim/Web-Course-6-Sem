using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using HttpServer.Enums;

namespace HttpServer.Models
{
    internal class HttpResponse
    {
        public HttpStatusCode StatusCode { get; set; }
        public string Description { get; set; }
        public byte[] Content { get; set; }
        public Dictionary<string, string> Headers { get; set; }
        public string ContentInUtf8
        {
            set
            {
                SetContent(value, Encoding.UTF8);
            }
        }

        public void SetContent(string content, Encoding encoding = null)
        {
            encoding = encoding ?? Encoding.UTF8;
            Content = encoding.GetBytes(content);
        }

        public HttpResponse()
        {
            Headers = new Dictionary<string, string>();
        }

        public override string ToString()
        {
            return $"HTTP status {StatusCode} {Description}";
        }
    }
}
