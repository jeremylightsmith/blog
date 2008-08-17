DB = {}

task :load_mephisto do
  
end

task :production do
  DB[:user] = 'stellsmi'
  DB[:]
end

task :development do
  
end

namespace :db do
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