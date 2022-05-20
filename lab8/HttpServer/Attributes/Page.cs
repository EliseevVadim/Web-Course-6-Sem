using System;

namespace HttpServer.Attributes
{
    public class Page : Attribute
    {
        public string Uri { get; set; }

        public Page() { }
        public Page(string uri) => Uri = uri;
    }
}
