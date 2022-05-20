namespace HttpServer.App.Models
{
    public class Timespan
    {
        public int Id { get; set; }
        public int MonthId { get; set; }
        public Month Month { get; set; }
        public int WorkFormatId { get; set; }
        public WorkFormat WorkFormat { get; set; }
        public int ActivityId { get; set; }
        public Activity Activity { get; set; }
    }
}
