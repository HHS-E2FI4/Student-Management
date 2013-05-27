# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
  config.vm.box = "base"
  config.vm.box_url = "http://0ptr.org/vagrant/lamp.box"

  config.vm.network :forwarded_port, guest: 80, host: 8080
  config.vm.network :forwarded_port, guest: 3306, host: 3366
  
  config.vm.synced_folder "src", "/var/www"

  config.vm.provider :virtualbox do |vb|
  	vb.customize ["modifyvm", :id, "--memory", "1024"]
  	vb.customize ["modifyvm", :id, "--name", "lamp"]
  end
end
