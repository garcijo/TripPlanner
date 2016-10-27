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
box with `vagrant up`. This should take care of installing everything needed to
run the project. 

To reset the environment including the database:

```
$ vagrant provision
```

The url for this environment is `http://mytrip.plan`


###Project status:
Although currently not many features are available through the front-end, 
most of the back-end functions for the CRUD operations already exist.