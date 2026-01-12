# Router — “Who handles this URL?”
What the Router is <br />
The Router is responsible for:
- Reading the URL
- Matching it to a route
- Deciding which controller + method should run

Think of it as a traffic cop 🚦 for HTTP requests. <br /><br />

# Application — “Boot the system”
What the Application is <br />
The Application class is the orchestrator 🎼
It:
- Starts the app
- Creates core objects
- Connects everything together

Runs the router

What Application usually does
- Loads configuration
- Initializes Router
- Handles errors
- Starts request handling

Think of it as the engine starter 🚗 <br /><br />

# Request — “What did the client ask for?”
What the Request is 

You wrap everything in one clean object.<br />

What Request usually contains
- HTTP method (GET, POST)
- URL path
- Query params
- Body (JSON, form data)
- Headers
<br />

The Request class represents the HTTP request 📩 <br /><br />

