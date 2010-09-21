#We Give — [Charity Hack 2010](http://charityhack.org/) entry

This is entry by [Arran](https://twitter.com/arranrp), [Zoltan](https://twitter.com/zoltanray), [Heather](https://twitter.com/heatherAtaylor) and [me](https://twitter.com/pornelski).

##The point

In Web2.0-speak it's mix of Lanyrd and Groupon.

Allows people to set up challenge for their friends: I donated *X*, and if my friends donate *XX*, then I'll donate *X* more. 

For the challenger this gives good excuse to tell all their friends which causes he/she supports.

Friends can do something together towards a charitable goal. We're showing who's donated already, so there's peer pressure to join in.

We're pulling friends from Twitter, so users can browse their social graph and see what their friends support, discover new charities supported by their friends.

Company twist: companies can set up challenges as well. You can get your friends together to reach a set goal and make the company double what you've raised.

##The code

Code is pretty clean for something that was built literally overnight! Of course there are big unfinished gaps. 

###APIs

It uses PayPal AdaptivePayments API to pre-approve all payments upfront. MissionFish for discovery of charities and distribution of donations. Twitter OAuth for login and friends.

###Requirements to run it:

 * PHP 5.3
 * Postgresql
 * [PHP ActiveRecord](http://www.phpactiverecord.org/)
 * [PHPTAL](http://phptal.org)
 * [Twitter-async](http://github.com/jmathai/twitter-async)
 * Lighttpd (can be easily converted to Apache)
