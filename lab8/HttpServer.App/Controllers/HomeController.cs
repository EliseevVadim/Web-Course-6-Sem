using HttpServer.Attributes;
using Newtonsoft.Json;
using Newtonsoft.Json.Linq;
using System.Collections.Generic;
using System.Linq;
using System.Reflection;

namespace HttpServer.App.Controllers
{
    [Controller]
    public class HomeController
    {
        [Page("/index")]
        public JObject GetAllMethods()
        {
            Assembly currentAssembly = Assembly.GetExecutingAssembly();
            var controllers = currentAssembly.GetTypes()
                                .Where(type => type.GetCustomAttributes(typeof(Controller)).Any());
            List<MethodInfo> methods = new List<MethodInfo>();
            foreach (var controller in controllers)
            {
                List<MethodInfo> pageMethods = controller.GetMethods()
                                .Where(method => method.GetCustomAttributes(typeof(Page)).ToList().Count > 0)
                                .ToList();
                methods.AddRange(pageMethods);
            }
            string json = JsonConvert.SerializeObject(methods);
            return JObject.Parse(json);
        }
    }
}
