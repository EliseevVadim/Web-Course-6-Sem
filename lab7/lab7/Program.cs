using System;
using System.Collections.Generic;
using System.IO;
using System.Threading;
using lab7.Core;
using OpenQA.Selenium;
using OpenQA.Selenium.Chrome;
using System.Configuration;

namespace lab7
{
    [Obsolete]
    internal class Program
    {
        static void Main(string[] args)
        {
            string folderName = ConfigurationManager.AppSettings["initialUploadsFolder"];
            GoogleDriveManager manager = new GoogleDriveManager();
            manager.InitializeAuthorization();
            manager.CreateFolderIfNotExists(folderName);
            IWebDriver driver = new ChromeDriver();
            SeleniumDataSearcher searcher = new SeleniumDataSearcher(driver, manager);
            Console.Clear();
            searcher.StartSearching();
            Console.Clear();
            Console.WriteLine("Обработка завершена");
        }

    }
}
