using HttpServer.App.Models;
using HttpServer.Attributes;
using Newtonsoft.Json.Linq;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace HttpServer.App.Controllers
{
    [Controller]
    public class ActivitiesController
    {
        [Page("/get/activities/{id}")]
        public JObject GetWorkFormatById(int id)
        {
            using (ApplicationContext db = new ApplicationContext())
            {
                Activity result = db.Activities.Where(activity => activity.Id == id).FirstOrDefault();
                return JObject.FromObject(result);
            }
        }

        [Page("/delete/activities/{id}")]
        public JObject DeleteWorkFormatById(int id)
        {
            using (ApplicationContext db = new ApplicationContext())
            {
                Activity result = db.Activities.Where(activity => activity.Id == id).FirstOrDefault();
                db.Activities.Remove(result);
                db.SaveChanges();
                return JObject.Parse("{Result : Activity was deleted successfully}");
            }
        }

        [Page("/update/activities/{id}")]
        public JObject UpdateWorkFormatById(int id, Activity activity)
        {
            using (ApplicationContext db = new ApplicationContext())
            {
                db.Update(activity);
                db.SaveChanges();
                Activity result = db.Activities.Where(activity => activity.Id == id).FirstOrDefault();
                return JObject.FromObject(result);
            }
        }
    }
}
