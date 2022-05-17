using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Net.Sockets;

namespace HttpServer.Core
{
    internal class HttpServer
    {
        private int _port;
        private TcpListener _listener;
        private bool _isActive = true;
        private HttpProcessor _processor;
    }
}
