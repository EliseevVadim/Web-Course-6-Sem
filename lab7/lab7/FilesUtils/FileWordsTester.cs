using System.IO;

namespace lab7.FilesUtils
{
    internal class FileWordsTester
    {
        private string _path;

        public FileWordsTester(string path)
        {
            _path = path;
        }

        public bool WordIsInFile(string word)
        {
            using (StreamReader reader = new StreamReader(_path))
            {
                string line;
                while ((line = reader.ReadLine()) != null)
                {
                    if (line == word)
                        return true;
                }
            }
            return false;
        }
    }
}
