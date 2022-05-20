using System.Collections.Generic;

namespace HttpServer.App.Models
{
    public class Group
    {
        public int Id { get; set; }
        public string GroupName { get; set; }
        public List<Activity> Activities { get; set; }
    }
}
