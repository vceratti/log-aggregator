
### ASSUMPTIONS ABOUT THE PROBLEM:
The problem is divided in 2 main scopes:

(@TODO annotations express points that are not a priority but will be handled if there is time)

- reading log entries from a stream, parsing it and sending it to a service that handles them:
  - the log parser expect a simple format; messages respecting the format are sent to the message
bus while exceptions are logged and discarded 
    - @TODOs: process management + task failure / restart (add supervisor) 
, one line at a time while running)
    - @TODO log rotation (or any other log operation that is not appending lines to the file are NOT handled 

- the service that receive the log messages, validates / store them and exposes the endpoint for querying 
  - messages are read via message bus 
  - the (DDD) application validates the message, storing them in the database (RDMS / MySql)
    - edge cases / error handling is kept simple: invalid messages are logged and moved to a dead letter storage 
      - @TODO decide and implement dead letter (queue or DB) 
  - a REST service is provided for the required query and filters
    - for simplification / time restrictions some real life details may not be covered:
        - @TODO index optimization based on queries and filters combination OR
        - @TODO evaluate ElasticSearch as a better alternative for the dynamic querying (provide 2 versions?)

### ABOUT THE DEVELOPMENT PROCESS:

Approaches / Patterns: 
 - DDD is used despite the simplicity of the domain; We operate on aggregate roots that only exist in a valid state.
I believe is still the best pattern to organize SOLID code that can grow/last and express domain rules properly
 - TDD: all tasks are coding using the TDD goat approach
 - Versioning: each commit to main (from PRs) is a consistent deliverable and develops in iterations, mirroring how I
would divide the task in subtasks in a real life scenario
 - Storage: MySQL database is used from simplicity 

- Each commit to main (from PRs) is a consistent deliverable, mirroring how I would divide
the task in subtasks in a real life agile scenario


