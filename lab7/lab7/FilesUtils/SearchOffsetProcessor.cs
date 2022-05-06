using System.Configuration;
using System.IO;

namespace lab7.FilesUtils
{
    internal class SearchOffsetProcessor
    {
        private static string _offsetFilePath = ConfigurationManager.AppSettings["offsetFile"];
        public static int GetReadingOffset()
        {
            using (StreamReader reader = new StreamReader("offset.ini"))
            {
                return int.Parse(reader.ReadLine());
            }
        }

        public static void SetReadingOffset(int offset)
        {
            File.WriteAllText("offset.ini", offset.ToString());
        }
    }
}
