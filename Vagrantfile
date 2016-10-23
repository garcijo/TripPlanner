# -*- mode: ruby -*-
# vi: set ft=ruby :

$script = <<SCRIPT
  echo I am provisioning...
  date > vagrant_provisioned_at
  echo I am setting up nginx vhost configuration ...

  cp -rp /vagrant/scripts/mytrip.plan.conf /etc/nginx/conf.d/
  service nginx restart

  mysql -u vagrant -pvagrant -e "DROP DATABASE IF EXISTS mytrip";
  mysql -u vagrant -pvagrant -e "CREATE DATABASE mytrip";

  mysql -u vagrant -pvagrant < /vagrant/scripts/schema.sql

SCRIPT
Vagrant.configure(2) do |config|
  config.vm.box = "rasmus/php7dev"
  config.vm.provider "virtualbox" do |v|
    v.name = "my_vm"
  end
  #config.vm.customize ["modifyvm", :id, "--name", "Gangnam Style"]
  config.vm.network :private_network, ip: "10.0.60.12"
  config.vm.hostname = "mytrip.plan"
  config.hostmanager.enabled = true
  config.hostmanager.manage_host = true
  config.hostmanager.aliases = 'mytrip.plan'
  config.vm.synced_folder ".", "/vagrant", owner: "www-data", group: "www-data", mount_options: ['dmode=777']
  config.vm.provision "shell", inline: $script
end