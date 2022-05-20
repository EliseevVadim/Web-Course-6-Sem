using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace HttpServer.App.Models
{
    public class WorkFormat
    {
        public int Id { get; set; }
        public string FormatName { get; set; }
        public List<Timespan> Timespans { get; set; }
    }
}
