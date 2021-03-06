set :application, "blog"
set :user, "lightsmith"
set :home, "/users/home/lightsmith"
set :deploy_to, "#{home}/apps/#{application}"

set :scm, :git
set :repository, "git://github.com/jeremylightsmith/blog.git "
set :branch, "master"
set :deploy_via, :remote_cache

role :app, "onemanswalk.com"
role :web, "onemanswalk.com"
role :db,  "onemanswalk.com", :primary => true

desc "do a backup"
task :backup do
  run "cd #{deploy_to} && rake db:backup"
  # run "cd #{current_path} && rake db:backup"
end

desc "pull code from github"
task :pull do
  run "cd #{deploy_to}/../actionsite && git pull"
  run "cd #{deploy_to} && " +
      "git pull && " +
      "rake generate && " + 
      "ln -s -f #{home}/public/files #{deploy_to}/public/jeremy_lightsmith/files"
end 
