using System.Collections.Generic;

namespace HttpServer.App.Models
{
    public class Month
    {
        public int Id { get; set; }
        public string MonthName { get; set; }
        public List<Timespan> Timespans { get; set; }
    }
}
