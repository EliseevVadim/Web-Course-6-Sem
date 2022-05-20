using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace HttpServer.App.Models
{
    public class Discipline
    {
        public int Id { get; set; }
        public string DisciplineName { get; set; }
        public List<Activity> Activities { get; set; }
    }
}
