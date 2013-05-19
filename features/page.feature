Feature: Page
	In order to manage page
	As an administrator
	I should be able to edit the page content

	Scenario: Change page title
		Given I am on "/" 
		When I go to "/admin/page/1/edit"
			And I fill in "Titre de la page" with "Plop"
			And I press "Modifier cette page"
			And I go to "/"
		Then I should see "Plop" in the "h1" element