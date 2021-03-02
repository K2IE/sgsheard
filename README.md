# sgsheard
Last heard for the N7TAE smart-group-server

Quadnet recently removed last heard info for sgs servers that they do not operate from their dashboard.
This project provides a new dashboard that integrates nicely with the xlxd dashboard.

Requires: N7TAE/sgs-remote && (LX3JL/xlxd or N7TAE/new-xlxd)

Copy sgsheard.php into the pgs directory of your xlxd dashboard installation.
An index.php replacement is provided for the LX3JL dashboard.  Copy index.php into the htmlroot of your xlxd
dashbard installation.  If you're running an alternate xlxd version you'll have to diff and reconcile the 
needed changes to your index.php.

There are four configuration lines that need to be added to config.inc.php:

```# Enable sgsheard.php
$PageOptions['SGS']['Show']                          = true;         // Show SGS page

# sgs status page options
$PageOptions['SGSTitle']                             = 'Your Dashboard Title';
$PageOptions['SGSServer']	                  		     = 'servername'; //sgsremote <servername>
$PageOptions['PageRefreshAlt']                       = '60000';      // Alternate page refresh time in miliseconds
```

Thanks to Scott Weis (KB2EAR) for bootstrapping me with php assistance.

Copyright 2021 Dan Srebnick (K2IE) under the BSD-2-Clause license
