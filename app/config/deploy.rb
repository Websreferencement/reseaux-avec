# Capifony documentation: http://capifony.org
# Capistrano documentation: https://github.com/capistrano/capistrano/wiki

# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL

set :application, "reseauxAVEC"
set :domain,      "ks3094316.kimsufi.com"
set :deploy_to,   "/home/gears/www/ravec"
set :user,        "gears"

role :web,        domain
role :app,        domain
role :db,         domain, :primary => true

set :scm,         :git
set :repository,  "https://github.com/Websreferencement/reseaux-avec.git"
set :branch,      "master"
set :deploy_via,  :remote_cache

ssh_options[:forward_agent] = true
ssh_options[:port] = "8022"

set :use_composer,   true
set :update_vendors, true

set :writable_dirs,     ["app/cache", "app/logs"]
set :webserver_user,    "gears"

set :shared_files,    ["app/config/parameters.yml", "web/.htaccess", "web/robots.txt"]
set :shared_children, ["app/logs"]

set :model_manager, "doctrine"

set :use_sudo,    false

set :keep_releases, 3

set :dump_assetic_assets, true

before 'symfony:composer:update', 'symfony:copy_vendors'

namespace :symfony do
  desc "Copy vendors from previous release"
  task :copy_vendors, :except => { :no_release => true } do
    if Capistrano::CLI.ui.agree("Do you want to copy last release vendor dir then do composer install ?: (y/N)")
      capifony_pretty_print "--> Copying vendors from previous release"

      run "cp -a #{previous_release}/vendor #{latest_release}/"
      capifony_puts_ok
    end
  end
end

after "deploy:update", "deploy:cleanup"
