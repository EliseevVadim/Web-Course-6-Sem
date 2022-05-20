using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using HttpServer.Attributes;
using Newtonsoft.Json;
using HttpServer.App.Models;
using Newtonsoft.Json.Linq;

namespace HttpServer.App.Controllers
{
    [Controller]
    internal class GroupsController
    {
        [Page("/get/groups/{id}")]
        public JObject GetGroupById(int id)
        {
            using (ApplicationContext db = new ApplicationContext())
            {
                Group result = db.Groups.Where(group => group.Id == id).FirstOrDefault();
                return JObject.FromObject(result);
            }
        }

        [Page("/delete/groups/{id}")]
        public JObject DeleteGroupById(int id)
        {
            using (ApplicationContext db = new ApplicationContext())
            {
                Group result = db.Groups.Where(group => group.Id == id).FirstOrDefault();
                db.Groups.Remove(result);
                db.SaveChanges();
                return JObject.Parse("{Result : Group was deleted successfully}");
            }
        }

        [Page("/update/groups/{id}")]
        public JObject UpdateGroupById(int id, Group group)
        {
            using (ApplicationContext db = new ApplicationContext())
            {
                db.Update(group);
                db.SaveChanges();
                Group result = db.Groups.Where(group => group.Id == id).FirstOrDefault();
                return JObject.FromObject(result);
            }
        }
    }
}
