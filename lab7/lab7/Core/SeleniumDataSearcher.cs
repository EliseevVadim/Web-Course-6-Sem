using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Text;
using System.Threading.Tasks;
using OpenQA.Selenium;
using System.IO;
using System.Threading;
using lab7.FilesUtils;
using System.Configuration;

namespace lab7.Core
{
    internal class SeleniumDataSearcher
    {
        private string _url = "https://www.bukvarix.com/";
        private IWebDriver _driver;
        private GoogleDriveManager _googleDriveManager;
        private int _wordNumber;
        private string _sourceFile;

        public SeleniumDataSearcher(IWebDriver driver, GoogleDriveManager googleDriveManager)
        {
            _driver = driver;
            _googleDriveManager = googleDriveManager;
            _sourceFile = ConfigurationManager.AppSettings["initialFile"];
        }

        public void StartSearching()
        {
            _driver.Navigate().GoToUrl(_url);
            _wordNumber = SearchOffsetProcessor.GetReadingOffset();
            SearchWord();
            _driver.Close();
            _driver.Quit();
        }

        private string DownloadFile(string link)
        {
            using (var client = new WebClient())
            {
                client.DownloadFile(link, $"downloads/{_wordNumber.ToString()}.csv");
            }
            return $"downloads/{_wordNumber.ToString()}.csv";
        }

        private void SearchWord()
        {
            using (StreamReader reader = new StreamReader(_sourceFile))
            {
                for (int i = 0; i < _wordNumber; i++)
                {
                    reader.ReadLine();
                }
                string inputString = reader.ReadLine();
                if (String.IsNullOrEmpty(inputString))
                    return;
                Thread.Sleep(1000);
                _driver.FindElement(By.Id("SearchFormIndexQ")).SendKeys(inputString);
                _driver.FindElement(By.CssSelector("#search_form_index > div.search-form-submit-index > input[type=submit]")).Click();
                try
                {
                    string dowloadCsvLink = _driver.FindElement(By.ClassName("report-download-button")).GetAttribute("href");
                    if (dowloadCsvLink == null)
                        throw new Exception();
                    string dowloadedPath = DownloadFile(dowloadCsvLink);
                    CsvOutputParser parser = new CsvOutputParser(dowloadedPath);
                    reader.Close();
                    parser.ParseFile();
                    _googleDriveManager.UploadFile($"{_wordNumber.ToString()}.csv", dowloadedPath);
                }
                catch
                {
                    Console.WriteLine("Для заданного слова .csv файл отсутствует");
                }
                finally
                {
                    _driver.Navigate().Back();
                }
            }
            ++_wordNumber;
            SearchOffsetProcessor.SetReadingOffset(_wordNumber);
            Thread.Sleep(1000);
            Console.WriteLine("Слово успешно обработано");
            SearchWord();
        }

    }
}
