using System;
using System.Collections.Generic;
using System.Configuration;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading;
using System.Threading.Tasks;
using Google.Apis.Auth.OAuth2;
using Google.Apis.Drive.v3;
using Google.Apis.Services;
using Google.Apis.Util.Store;

namespace lab7.Core
{
    internal class GoogleDriveManager
    {
        private string _uploadsFolderName;
        private string _applicationName;
        private UserCredential _credential;
        private string[] _scopes; 
        private DriveService _driveService;

        public GoogleDriveManager()
        {
            _uploadsFolderName = ConfigurationManager.AppSettings["initialUploadsFolder"];
            _applicationName = ConfigurationManager.AppSettings["driveAppName"];
            _scopes = new string[]
            {
                DriveService.Scope.Drive,
                DriveService.Scope.DriveAppdata,
                DriveService.Scope.DriveFile,
                DriveService.Scope.DriveMetadataReadonly,
                DriveService.Scope.DriveReadonly,
                DriveService.Scope.DriveScripts
            };
        }

        [Obsolete]
        public void InitializeAuthorization()
        {
            using (var stream =
                new FileStream("credentials.json", FileMode.Open, FileAccess.Read))
            {
                // The file token.json stores the user's access and refresh tokens, and is created
                // automatically when the authorization flow completes for the first time.
                string credPath = "token.json";
                _credential = GoogleWebAuthorizationBroker.AuthorizeAsync(
                    GoogleClientSecrets.Load(stream).Secrets,
                    _scopes,
                    "user",
                    CancellationToken.None,
                    new FileDataStore(credPath, true)).Result;
                Console.WriteLine("Credential file saved to: " + credPath);
            }

            // Create Drive API service.
            _driveService = new DriveService(new BaseClientService.Initializer()
            {
                HttpClientInitializer = _credential,
                ApplicationName = _applicationName,
            });
        }

        public void CreateFolderIfNotExists(string name)
        {
            var request = _driveService.Files.List();
            request.Q = "mimeType = 'application/vnd.google-apps.folder'";
            var response = request.Execute();
            if (response.Files.Any(file => file.Name == name))
                return;
            var folderData = new Google.Apis.Drive.v3.Data.File()
            {
                Name = name,
                MimeType = "application/vnd.google-apps.folder",
                Parents = new[] { "root" }
            };
            var creatingRequest = _driveService.Files.Create(folderData);
            creatingRequest.Execute();
        }

        public void UploadFile(string fileName, string path)
        {
            var request = _driveService.Files.List();
            request.Q = "mimeType = 'application/vnd.google-apps.folder'";
            var response = request.Execute();
            string id = response.Files.Where(file => file.Name == _uploadsFolderName).FirstOrDefault().Id;
            var fileData = new Google.Apis.Drive.v3.Data.File()
            {
                Name = fileName,
                MimeType = "application/vnd.google-apps.spreadsheet",
                Parents = new[] { id }
            };
            FilesResource.CreateMediaUpload uploadRequest;
            using (var stream = new System.IO.FileStream(path, System.IO.FileMode.Open))
            {
                uploadRequest = _driveService.Files.Create(
                    fileData, stream, "text/csv");
                request.Fields = "id";
                uploadRequest.Upload();
            }
        }
    }
}
