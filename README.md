# TripPlanner

##Description:
A little app so you don't forget anything on your next trip! 
This application allows users to create lists of items they need for their trip.
These items can either be assigned to a specific bag or be flagged as needed to buy.
All items, bags, and trips can also be updated and deleted at any time.


##Installation:
A `Vagrantfile` and a set of `scripts` have been provided to facilitate the installation
of this project.

In order to create and run the vagrant box, `Oracle VirtualBox` and `Vagrant`
need to be installed.

Once vagrant is installed, make sure you also install the hostmanager plugin:
```
$ vagrant plugin install vagrant-hostmanager
```

Once this is installed, switch to the directory of the cloned repo and start the vagrant 
box with `vagrant up`; this should take care of installing most things needed to
run the project. 

After vagrant is setup, the only remaining thing to install will be the Composer dependencies. 
To do this, first connect to the vagrant box and move to the vagrant directory:
```
$ vagrant ssh
$ cd /vagrant
```
Once here, run `composer install`. Once the dependencies are done installing you'll be good to go!



If needed, you can reset the environment including the database by provisioning the vagrant box:

```
$ vagrant provision
```

The url for this project is `http://mytrip.plan`


###Project status:
Although currently not many features are available through the front-end, 
most of the back-end functions for the CRUD operations already exist.