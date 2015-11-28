## jobEQ API authorization

Authorization is required to use [jobEQ API](http://www.jobeq.info/api/). Application should provide valid access token with every API request. Authorization is based on oAuth2 protocol, implicit scenario is used. Note that in order to use jobEQ API application also needs to receive a secret key and ID from jobEQ, please mail jobEQ to register your app. 

### How to start using jobEQ API ?

1. Register your client application and receive __secret key__ and __application ID__, by sending email to jobEQ.
2. Authorize application access through __jobEQ authorization service__. 
3. Call API functions through http adding __access token__ to each request.

### Authorization flow

All API requests are executed on behalf of HR user, jobEQ has to know which resources are accessible for client application, so authorization procedure will ask HR user to confirm that application can use his/her data retrieved from jobEQ. 

1. When registering application in jobEQ __redirection url__ should be provided. HR user will be redirected to that url after authentication is processed in __jobEQ authorization service__. 
2. Before calling jobEQ API client application should redirect user to __jobEQ authorization service__, sending __application ID__ in request, so jobEQ knows where request is coming from. 
3. __jobEQ authorization service__ will perform HR user authentication and will redirect back to __redirection url__ mentioned in 1. The redirection request will also contain __authorization code__. 
4. Client application software should exchange __authorization code__ and __secret key__ to __access token__. 
5. Client application can now perform API request adding __access token__ in request headers.

### Example

Suppose you've created a new application which will be interacting with jobEQ through jobEQ API. Your application is on web-site http://my-app.com (it can also be desktop or mobile app), you will require users of your application to sign in and interact with data from jobEQ on behalf of those users. 
