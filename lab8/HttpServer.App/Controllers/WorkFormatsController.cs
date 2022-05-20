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
    public class WorkFormatsController
    {
        [Page("/get/workformats/{id}")]
        public JObject GetWorkFormatById(int id)
        {
            using (ApplicationContext db = new ApplicationContext())
            {
                WorkFormat result = db.WorkFormats.Where(format => format.Id == id).FirstOrDefault();
                return JObject.FromObject(result);
            }
        }

        [Page("/delete/workformats/{id}")]
        public JObject DeleteWorkFormatById(int id)
        {
            using (ApplicationContext db = new ApplicationContext())
            {
                WorkFormat result = db.WorkFormats.Where(format => format.Id == id).FirstOrDefault();
                db.WorkFormats.Remove(result);
                db.SaveChanges();
                return JObject.Parse("{Result : Work format was deleted successfully}");
            }
        }

        [Page("/update/workformats/{id}")]
        public JObject UpdateWorkFormatById(int id, WorkFormat workFormat)
        {
            using (ApplicationContext db = new ApplicationContext())
            {
                db.Update(workFormat);
                db.SaveChanges();
                WorkFormat result = db.WorkFormats.Where(format => format.Id == id).FirstOrDefault();
                return JObject.FromObject(result);
            }
        }
    }
}
