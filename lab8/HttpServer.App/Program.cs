using HttpServer.App.Models;
using HttpServer.Enums;
using HttpServer.Models;
using System;
using System.Collections.Generic;
using System.Threading;

namespace HttpServer.App
{
    internal class Program
    {
        static void Main(string[] args)
        {
            ApplicationContext context = new ApplicationContext();
            List<Route> routes = new List<Route>()
            {
                new Route()
                {
                    Name = "Get all methods",
                    Url =  "/index",
                    Method = HttpMethod.GET
                },
                new Route()
                {
                    Name = "Get group by id",
                    Url = "/get/groups/{id}",
                    Method = HttpMethod.GET
                },
                new Route()
                {
                    Name = "Delete group by id",
                    Url = "/delete/groups/{id}",
                    Method = HttpMethod.GET
                },
                new Route()
                {
                    Name = "Update group by id",
                    Url = "/update/groups/{id}",
                    Method = HttpMethod.POST
                },
                new Route()
                {
                    Name = "Get discipline by id",
                    Url = "/get/disciplines/{id}",
                    Method = HttpMethod.GET
                },
                new Route()
                {
                    Name = "Delete discipline by id",
                    Url = "/delete/disciplines/{id}",
                    Method = HttpMethod.GET
                },
                new Route()
                {
                    Name = "Update discipline by id",
                    Url = "/update/disciplines/{id}",
                    Method = HttpMethod.POST
                },
                new Route()
                {
                    Name = "Get month by id",
                    Url = "/get/months/{id}",
                    Method = HttpMethod.GET
                },
                new Route()
                {
                    Name = "Delete month by id",
                    Url = "/delete/months/{id}",
                    Method = HttpMethod.GET
                },
                new Route()
                {
                    Name = "Update month by id",
                    Url = "/update/months/{id}",
                    Method = HttpMethod.POST
                },
                new Route()
                {
                    Name = "Get work format by id",
                    Url = "/get/workformats/{id}",
                    Method = HttpMethod.GET
                },
                new Route()
                {
                    Name = "Delete work format by id",
                    Url = "/delete/workformats/{id}",
                    Method = HttpMethod.GET
                },
                new Route()
                {
                    Name = "Update work format by id",
                    Url = "/update/workformats/{id}",
                    Method = HttpMethod.POST
                },
                new Route()
                {
                    Name = "Get activity by id",
                    Url = "/get/activities/{id}",
                    Method = HttpMethod.GET
                },
                new Route()
                {
                    Name = "Delete activity by id",
                    Url = "/delete/activities/{id}",
                    Method = HttpMethod.GET
                },
                new Route()
                {
                    Name = "Update activity by id",
                    Url = "/update/activities/{id}",
                    Method = HttpMethod.POST
                },
                new Route()
                {
                    Name = "Get timespan by id",
                    Url = "/get/timespans/{id}",
                    Method = HttpMethod.GET
                },
                new Route()
                {
                    Name = "Delete timespan by id",
                    Url = "/delete/timespans/{id}",
                    Method = HttpMethod.GET
                },
                new Route()
                {
                    Name = "Update timespan by id",
                    Url = "/update/timespans/{id}",
                    Method = HttpMethod.POST
                }
            };
            Core.HttpServer httpServer = new Core.HttpServer(8080, routes);
            Thread thread = new Thread(new ThreadStart(httpServer.Listen));
            thread.Start();
            Console.WriteLine("The server was started at http://localhost:8080");
        }
    }
}
