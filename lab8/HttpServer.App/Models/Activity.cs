using System;
using System.Collections.Generic;

namespace HttpServer.App.Models
{
    public class Activity
    {
        public int Id { get; set; }
        public DateTime Date { get; set; }
        public int Course { get; set; }
        public int GroupId { get; set; }
        public Group Group { get; set; }
        public int DisciplineId { get; set; }
        public Discipline Discipline { get; set; }
        public int Lections { get; set; }
        public int Practics { get; set; }
        public int Labs { get; set; }
        public int Modules { get; set; }
        public int SemesterConsultations { get; set; }
        public int ExamConsultations { get; set; }
        public int Passes { get; set; }
        public int Exams { get; set; }
        public int Courseworks { get; set; }
        public int BachelorsFQW { get; set; }
        public int MastersFQW { get; set; }
        public int PracticeManagement { get; set; }
        public int GrandExams { get; set; }
        public int FQWReviewing { get; set; }
        public int FQWPresenting { get; set; }
        public int AspirantsManagement { get; set; }
        public int Others { get; set; }
        public List<Timespan> Timespans { get; set; }
    }
}
