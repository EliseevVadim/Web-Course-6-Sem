using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Net.Sockets;
using System.Net;
using HttpServer.Models;
using System.Threading;

namespace HttpServer.Core
{
    public class HttpServer
    {
        private int _port;
        private TcpListener _listener;
        private bool _isActive = true;
        private HttpProcessor _processor;

        public HttpServer(int port, List<Route> routes)
        {
            _port = port;
            _processor = new HttpProcessor();
            foreach(var route in routes)
            {
                _processor.AddRoute(route);
            }
        }

        public void Listen()
        {
            _listener = new TcpListener(IPAddress.Any, _port);
            _listener.Start();
            while (_isActive)
            {
                TcpClient client = _listener.AcceptTcpClient();
                Thread thread = new Thread(() =>
                {
                    _processor.HandleClient(client);
                });
                thread.Start();
                Thread.Sleep(1);
            }
        }
    }
}
