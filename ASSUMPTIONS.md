
### ASSUMPTIONS ABOUT THE PROBLEM:
The problem is divided in 2 main scopes:

(@TODO annotations express points that are not a priority but will be handled if there is time)

- reading log entries from a stream, parsing it and sending it to a service that handles them:
  - the log parser expect a simple format; messages respecting the format are sent to the message
bus while exceptions are logged and discarded 
    - @TODO process management (add supervisor)
    - @TODO task failure / restart
    - @TODO concurrency / performance (a single command reads continuously the single log from the beginning as a stream 
, one line at a time while running)
      - @TODO consider batch parsing / messaging
    - @TODO log rotation (or any other log operation that is not appending lines to the file)

- the service that receive the log messages, validates / store them and exposes the endpoint for querying 
  - messages are read via message bus 
    - @TODO decide on the message bus
  - the (DDD) application validates the message, storing them in the database (RDMS / MySql)
    - edge cases / error handling is kept simple: invalid messages are logged and moved to a dead letter storage 
      - @TODO decide: dead letter queue or DB?       
  - a REST service is provided for the required query and filters
    - for simplification / time restrictions some real life details may not be covered:
      - @TODO authentication
      - @TODO cache
      - @TODO api versioning or restrictions / rate limit
      - @TODO security
      - @TODO performance optimization 
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

### NOTES: 

- I took this task also as exercise/learning some concepts and libraries: 
 - TDD, DDD, SOLID, [The Twelve-Factor App](https://12factor.net) 
 - High test coverage with #Covers attributes to prevent [unintentional code coverage](https://docs.phpunit.de/en/10.2/risky-tests.html#risky-tests-unintentionally-covered-code)
 - strict code rules checked by [phpmd](phpmd.xml) 
 - strict typing with generics checked by [phpstan](phpstan.neon.dist)
