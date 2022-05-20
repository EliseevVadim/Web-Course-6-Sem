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
    public class MonthsController
    {
        [Page("/get/months/{id}")]
        public JObject GetMonthById(int id)
        {
            using (ApplicationContext db = new ApplicationContext())
            {
                Month result = db.Months.Where(month => month.Id == id).FirstOrDefault();
                return JObject.FromObject(result);
            }
        }

        [Page("/delete/months/{id}")]
        public JObject DeleteMonthById(int id)
        {
            using (ApplicationContext db = new ApplicationContext())
            {
                Month result = db.Months.Where(month => month.Id == id).FirstOrDefault();
                db.Months.Remove(result);
                db.SaveChanges();
                return JObject.Parse("{Result : Month was deleted successfully}");
            }
        }

        [Page("/update/months/{id}")]
        public JObject UpdateMonthById(int id, Month month)
        {
            using (ApplicationContext db = new ApplicationContext())
            {
                db.Update(month);
                db.SaveChanges();
                Month result = db.Months.Where(month => month.Id == id).FirstOrDefault();
                return JObject.FromObject(result);
            }
        }
    }
}
