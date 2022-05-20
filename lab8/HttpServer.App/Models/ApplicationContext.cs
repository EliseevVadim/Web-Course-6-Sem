using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using Microsoft.EntityFrameworkCore;

namespace HttpServer.App.Models
{
    internal class ApplicationContext : DbContext
    {
        public DbSet<Group> Groups { get; set; }
        public DbSet<WorkFormat> WorkFormats { get; set; }
        public DbSet<Discipline> Disciplines { get; set; }
        public DbSet<Month> Months { get; set; }
        public DbSet<Activity> Activities { get; set; }
        public DbSet<Timespan> Timespans { get; set; }

        public ApplicationContext()
        {
            Database.EnsureCreated();
        }

        protected override void OnConfiguring(DbContextOptionsBuilder optionsBuilder)
        {
            optionsBuilder.UseMySQL(
                "server=localhost;user=root;password=root;database=web_lab8_db"
            );
        }
    }
}
