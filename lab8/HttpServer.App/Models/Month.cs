using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace HttpServer.App.Models
{
    public class Month
    {
        public int Id { get; set; }
        public string MonthName { get; set; }
        public List<Timespan> Timespans { get; set; }
    }
}
