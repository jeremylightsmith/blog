set :application, "blog"
set :user, "stellsmi"
set :home, "/users/home/stellsmi"
set :deploy_to, "#{home}/apps/#{application}"

set :scm, :git
set :repository, "git://github.com/jeremylightsmith/blog.git "
set :branch, "master"
set :deploy_via, :remote_cache

# If you aren't deploying to /u/apps/#{application} on the target
# servers (which is the default), you can specify the actual location
# via the :deploy_to variable:
# set :deploy_to, "/var/www/#{application}"

# If you aren't using Subversion to manage your source code, specify
# your SCM below:
# set :scm, :subversion

role :app, "onemanswalk.com"
role :web, "onemanswalk.com"
role :db,  "onemanswalk.com", :primary => true

# deploy.task :after_symlink do
#   run "ln -nfs #{home}/apps/rails-2.0.1 #{current_path}/vendor/rails"
#   run "ln -nfs #{shared_path}/log #{current_path}/public/log" 
# end
# 
# deploy.task :restart do
#   run "kill `cat #{home}/var/run/fcgi-#{application}.pid`"
# end
# 
# deploy.task :start do
# end

desc "do a backup"
task :backup do
  run "cd #{deploy_to} && rake db:backup"
  # run "cd #{current_path} && rake db:backup"
end