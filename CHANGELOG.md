# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) 
and this project adheres to [Semantic Versioning](http://semver.org/).

## [0.2.0] - 2016-10-30
### Added
- Allow memberships to be handled more realistically (4)
- Show a list of all defined rounds (11)
- Add user profile links to user menu in committee tools (32)

### Changed
- Migrate previous score data from old database to new website database (26)
- User profile layout (both view and edit) has been improved with the addition of memberships

### Fixed
- User creation fails when the birth date is left empty (30)
- When no scores have been submitted for a user, there is no on-screen message (33)

## [0.1.0] - 2016-10-15
### Added
- Show a simple user profile within the committee section when a user's name is clicked on (1)
- Send a welcome email to newly registered users (6)
- Add novice status to user profiles (28)
   
### Changed
- Allow committee members to set more properties on user accounts (2)
- Make the user list paged, sortable and filterable (7)
- Hide tools in the top-bar until they are available (8)