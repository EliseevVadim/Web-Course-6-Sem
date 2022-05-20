using System.Collections.Generic;

namespace HttpServer.App.Models
{
    public class Discipline
    {
        public int Id { get; set; }
        public string DisciplineName { get; set; }
        public List<Activity> Activities { get; set; }
    }
}
