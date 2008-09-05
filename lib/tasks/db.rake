require 'yaml'

class DB
  def self.init
    @settings = YAML::load_file(File.dirname(__FILE__) + "/../../config/database.yml")
    puts @settings.inspect
    @user, @pass, @host = @settings["username"], @settings["password"], @settings["host"]
  end
  
  def self.create_database(db)
    run "mysqladmin -u#{@user} -p#{@pass} -h#{@host} -f drop #{db}", :ignore_errors => true
    run "mysqladmin -u#{@user} -p#{@pass} -h#{@host} create #{db}"
  end
  
  def self.import_sql(db, file)
    run "mysql -u#{@user} -p#{@pass} -h#{@host} #{db} < #{file}"
  end
  
  def self.import_sql_gz(db, file)
    run "gunzip -c #{file} | mysql -u#{@user} -p#{@pass} -h#{@host} #{db}"
  end
  
  def self.export_sql_gz(db, name)
    file = Time.now.strftime "#{name}-%Y%m%d%H%M.sql"
    run "mysqldump -u#{@user} -p#{@pass} -h#{@host} #{db} > #{file}"
    run "gzip -f #{file}"
    Dir.chdir(File.dirname(name)) do
      run "ln -s -f #{File.basename(file)}.gz #{File.basename(name)}-latest.sql.gz"
    end
  end
  
  def self.execute(db, sql)
    run "mysql -u#{@user} -p#{@pass} -h#{@host} #{db} -e \"#{sql}\""
  end
      
  
  def self.run(cmd, options = {})
    puts cmd
    output = `#{cmd}`.strip
    puts output
    raise output unless $? == 0 or options[:ignore_errors] == true
  end
end


task :init do
  DB.init
end

namespace :db do
  task :setup => :init do
    DB.create_database('stellsmi_wordpress_life')
    DB.create_database('stellsmi_wordpress_work')
  end

  task :load_mephisto => :init do
    DB.create_database('stellsmi_mephisto')
    DB.import_sql('stellsmi_mephisto', 'stellsmi_mephisto.sql')
  end
  
  desc "backup dbs"
  task :backup => :init do
    DB.export_sql_gz("stellsmi_wordpress_life", "db/backups/life")
    DB.export_sql_gz("stellsmi_wordpress_work", "db/backups/work")
  
    Rake::Task["db:rotate_backups"].invoke
  end

  desc "restore dbs"
  task :restore => :setup do    
    DB.import_sql_gz("stellsmi_wordpress_life", "db/backups/life-latest.sql.gz")
    DB.import_sql_gz("stellsmi_wordpress_work", "db/backups/work-latest.sql.gz")
  end
  
  desc "set siteurl to localhost"
  task :set_local => :setup do
    host = ENV['HOST'] || "localhost"
    
    DB.execute("stellsmi_wordpress_work", 
      "update wp_options set option_value = 'http://#{host}/work' where option_name in ('siteurl', 'home')")
    DB.execute("stellsmi_wordpress_life",
      "update wp_options set option_value = 'http://#{host}/life' where option_name in ('siteurl', 'home')")
  end
  
  task :rotate_backups do
    backups = Dir["db/backups/*.sql.gz"].reject {|file| file =~ /latest/}.sort {|a, b| File.mtime(a) <=> File.mtime(b)}
    backups[0..-10].each do |file| # everything but the last 10
      puts "deleting #{file}"
      FileUtils.rm(file)
    end
  end
  
  task :pull do
    Dir.chdir("db/backups") do
      DB.run "scp stellsmi@onemanswalk.com:apps/blog/db/backups/*-latest.sql.gz ."
    end
  end
end
