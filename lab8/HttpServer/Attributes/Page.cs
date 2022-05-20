using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace HttpServer.Attributes
{
    public class Page : Attribute
    {
        public string Uri { get; set; }

        public Page() { }
        public Page(string uri) => Uri = uri;
    }
}
