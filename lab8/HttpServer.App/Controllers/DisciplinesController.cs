using HttpServer.App.Models;
using HttpServer.Attributes;
using Newtonsoft.Json.Linq;
using System.Linq;

namespace HttpServer.App.Controllers
{
    [Controller]
    public class DisciplinesController
    {
        [Page("/get/disciplines/{id}")]
        public JObject GetDisciplineById(int id)
        {
            using (ApplicationContext db = new ApplicationContext())
            {
                Discipline result = db.Disciplines.Where(discipline => discipline.Id == id).FirstOrDefault();
                return JObject.FromObject(result);
            }
        }

        [Page("/delete/disciplines/{id}")]
        public JObject DeleteDisciplineById(int id)
        {
            using (ApplicationContext db = new ApplicationContext())
            {
                Discipline result = db.Disciplines.Where(discipline => discipline.Id == id).FirstOrDefault();
                db.Disciplines.Remove(result);
                db.SaveChanges();
                return JObject.Parse("{Result : Discipline was deleted successfully}");
            }
        }

        [Page("/update/disciplines/{id}")]
        public JObject UpdateDisciplineById(int id, Discipline discipline)
        {
            using (ApplicationContext db = new ApplicationContext())
            {
                db.Update(discipline);
                db.SaveChanges();
                Discipline result = db.Disciplines.Where(discipline => discipline.Id == id).FirstOrDefault();
                return JObject.FromObject(result);
            }
        }
    }
}
