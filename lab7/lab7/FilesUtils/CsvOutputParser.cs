using CsvHelper;
using CsvHelper.Configuration;
using System.Configuration;
using System.Globalization;
using System.IO;
using System.Text;

namespace lab7.FilesUtils
{
    internal class CsvOutputParser
    {
        private string _path;
        private FileWordsTester _wordsTester;
        private string _sourceFile;

        public CsvOutputParser(string path)
        {
            _sourceFile = ConfigurationManager.AppSettings["initialFile"];
            _path = path;
            _wordsTester = new FileWordsTester("words.txt");
        }

        public void ParseFile()
        {
            var csvConfig = new CsvConfiguration(CultureInfo.InvariantCulture)
            {
                Encoding = Encoding.UTF8,
                Delimiter = ";",
            };
            using (TextReader reader = File.OpenText(_path))
            {
                using (CsvReader csvReader = new CsvReader(reader, csvConfig))
                {
                    csvReader.Read();
                    while (csvReader.Read())
                    {
                        string line = csvReader.GetField(0);
                        if (_wordsTester.WordIsInFile(line))
                            continue;
                        File.AppendAllText(_sourceFile, "\n" + line);
                    }
                }
            }
        }
    }
}
