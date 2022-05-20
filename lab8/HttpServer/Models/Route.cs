using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using HttpServer.Enums;

namespace HttpServer.Models
{
    public class Route
    {
        public string Name { get; set; }
        public string Url { get; set; }
        public HttpMethod Method { get; set; }
    }
}
