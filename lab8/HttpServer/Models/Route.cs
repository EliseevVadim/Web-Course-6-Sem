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
