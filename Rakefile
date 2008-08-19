require 'yaml'

class DB
  def self.init(environment)
    @settings = YAML::load_file(File.dirname(__FILE__) + "/config/database.yml")[environment]
    puts @settings.inspect
    @user, @pass, @host = @settings[:username], @settings[:password], @settings[:host]
  end
  
  def self.create_database(db)
    run "mysqladmin -u#{@user} -p#{@pass} -h#{@host} -f drop #{db}", :ignore_errors => true
    run "mysqladmin -u#{@user} -p#{@pass} -h#{@host} create #{db}"
  end
  
  def self.import_sql(file, db)
    run "mysql -u#{@user} -p#{@pass} -h#{@host} #{db} < #{file}"
  end
  
  def self.import_sql_gz(file, db)
    run "gunzip -c #{file} | mysql -u#{@user} -p#{@pass} -h#{@host} #{db}"
  end
  
  def self.run(cmd, options = {})
    puts cmd
    output = `#{cmd}`.strip
    puts output
    raise output unless $? == 0 or options[:ignore_errors] == true
  end
end


task :init do
  DB.init(:development)
end

task :production => :init do
  DB.init(:production)
end

task :install => :init do
  `open http://localhost/work/wp-admin/install.php`
  `open http://localhost/life/wp-admin/install.php`
end

namespace :db do
  task :setup => :init do
    DB.create_database('stellsmi_wordpress_life')
    DB.create_database('stellsmi_wordpress_work')
  end

  task :load_mephisto => :init do
    DB.create_database('mephisto_dev')
    DB.import_sql('stellsmi_mephisto.sql', 'mephisto_dev')
  end
  
  task :backup do
    type = ENV['TYPE'] || "nightly"
    db, user, pass, host = load_database_settings
    Dir.chdir("#{RAILS_ROOT}/db/backups") do
      output = Date.today.strftime "#{type}-%Y-%m-%d.sql"

      r "mysqldump -u#{user} -p#{pass} -h#{host} #{db} > #{output}"
      r "gzip -f #{output}"
      r "ln -s -f #{output}.gz nightly-latest.sql.gz"
    end
  
    Rake::Task["db:rotate_backups"].invoke
  end

  task :restore_mephisto do
    raise "you must call production or development before this tag" if DB.empty?
    
    db, user, pass, host = load_database_settings

    Dir.chdir("#{RAILS_ROOT}/db/backups") do
      input = "nightly-latest.sql.gz"
      # r "gunzip -f #{input}.gz" if File.exist?("#{input}.gz") # symlinks are ignored, so we must force it

      r "mysqladmin -u#{user} -p#{pass} -h#{host} -f drop #{db}", :ignore_errors => true
      r "mysqladmin -u#{user} -p#{pass} -h#{host} create #{db}"
      r "gunzip -c #{input} | mysql -u#{user} -p#{pass} -h#{host} #{db}"
    end
  end
end