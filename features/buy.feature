Feature: Buy
  I need to be able to use cart and buy products

  @javascript
  Scenario: Buy product
    Given I am on "/p-g6830742-harmony-dog-natural-black-angus-adult/"
    Then I wait for the page to load "#option-label-item_weight-230-item-2503" element
    Then I click the "5kg" element
    Then I pause
    Then I click the "In den Warenkorb" element
    Then I wait for the page to load "#ajax-add-to-cart-popup.is-active" element
    Then I click the "Zur Kasse" element
    Then I wait for the page to load ".login-section" element
    Then I click the "Als Gast" link
    Then I enter "email" with "test778899@refusion.com"
    Then I select "Frau" from "billingAddress_gender"
    Then I fill in "billingAddress_firstname" with "Heidi"
    Then I fill in "billingAddress_lastname" with "Tester"
    Then I fill in "billingAddress_street0" with "Testweg 11"
    Then I fill in "billingAddress_postcode" with "8006"
    Then I fill in "billingAddress_telephone" with "0445200185"
    Then I press "Weiter"
    Then I pause
#    Then breakpoint
#    Then I wait for the page to show "Lieferoptionen" if not click "Weiter"
    Then I wait for the page to show "Lieferoptionen"
    Then if I see "Rechnungsadresse" I should press "button" "Weiter"
    Then I wait for the page to load "#ajax-add-to-cart-popup" element
    Then I pause
    Then I select "standard" from "shipping-method"
    Then I press "Weiter"
    Then I pause
#    Then breakpoint
    Then I wait for the page to show "Zahlungsart"
    Then I wait for the page to load "#ajax-add-to-cart-popup" element
#    Then I select "invoice-radio" from "payment-method"
    Then I click the "Rechnung" element
#    Then breakpoint
    Then I press "Weiter"
    Then I press "Jetzt kaufen"
#    Then breakpoint
    Then I pause
    Then I should see "Bestellung erfolgreich"