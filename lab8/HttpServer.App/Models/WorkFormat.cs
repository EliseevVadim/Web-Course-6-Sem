using System.Collections.Generic;

namespace HttpServer.App.Models
{
    public class WorkFormat
    {
        public int Id { get; set; }
        public string FormatName { get; set; }
        public List<Timespan> Timespans { get; set; }
    }
}
