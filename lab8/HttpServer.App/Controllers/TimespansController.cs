using HttpServer.App.Models;
using HttpServer.Attributes;
using Newtonsoft.Json.Linq;
using System.Linq;

namespace HttpServer.App.Controllers
{
    [Controller]
    public class TimespansController
    {
        [Page("/get/timespans/{id}")]
        public JObject GetWorkFormatById(int id)
        {
            using (ApplicationContext db = new ApplicationContext())
            {
                Timespan result = db.Timespans.Where(timespan => timespan.Id == id).FirstOrDefault();
                return JObject.FromObject(result);
            }
        }

        [Page("/delete/timespans/{id}")]
        public JObject DeleteWorkFormatById(int id)
        {
            using (ApplicationContext db = new ApplicationContext())
            {
                Timespan result = db.Timespans.Where(timespan => timespan.Id == id).FirstOrDefault();
                db.Timespans.Remove(result);
                db.SaveChanges();
                return JObject.Parse("{Result : Timespan was deleted successfully}");
            }
        }

        [Page("/update/timespans/{id}")]
        public JObject UpdateWorkFormatById(int id, Timespan timespan)
        {
            using (ApplicationContext db = new ApplicationContext())
            {
                db.Update(timespan);
                db.SaveChanges();
                WorkFormat result = db.WorkFormats.Where(timespan => timespan.Id == id).FirstOrDefault();
                return JObject.FromObject(result);
            }
        }
    }
}
