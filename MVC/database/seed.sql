-- seed data for Online Food Blog
-- run AFTER schema.sql
-- default users:
--   admin@foodly.com / admin123
--   sara@foodly.com  / member123

USE online_food_blog;

-- clear in dependency order (skip if first run)
DELETE FROM food_experience_comments;
DELETE FROM food_experience_posts;
DELETE FROM reviews;
DELETE FROM menu_items;
DELETE FROM restaurants;
DELETE FROM users;

-- users
INSERT INTO users (name, email, password_hash, role, profile_picture) VALUES
('Admin User', 'admin@foodly.com',
 '$2y$12$mr7MC3vrHbQ5MgZCN1dcsez3z4uaxIPIeGOP4z5b.wY2ix54Ad5HW',
 'admin', NULL),
('Sara Ahmed', 'sara@foodly.com',
 '$2y$12$uoDY1fpgG9AMBqigkys6n.0oAwD8JiwcN.YD.dE7wF2WJlQs.cUIG',
 'member', NULL),
('Tariq Khan', 'tariq@foodly.com',
 '$2y$12$uoDY1fpgG9AMBqigkys6n.0oAwD8JiwcN.YD.dE7wF2WJlQs.cUIG',
 'member', NULL);

-- restaurants
INSERT INTO restaurants (name, location, area, short_background, goals) VALUES
('Spice Route', 'Dhaka', 'Dhanmondi',
 'A modern take on traditional Bengali flavors, founded in 2015 by Chef Imran.',
 'Bring back home-style cooking with seasonal, locally-sourced ingredients.'),
('Sunset Cafe', 'Dhaka', 'Gulshan',
 'Coastal-inspired menu with fresh seafood and a relaxed terrace seating.',
 'A peaceful escape in the middle of the city with food that feels like a holiday.'),
('Old Town Grill', 'Chittagong', 'Agrabad',
 'Charcoal grill specialty house known for slow-cooked kebabs.',
 'Honest, smoky, no-fuss grilled food at a fair price.');

-- menu items (referencing restaurants by id 1..3)
INSERT INTO menu_items (restaurant_id, name, description, price, image_path) VALUES
(1, 'Beef Bhuna', 'Slow-cooked beef in dark, fragrant masala. Served with steamed basmati.', 380.00, NULL),
(1, 'Hilsa Paturi', 'Hilsa fish marinated in mustard paste, wrapped in banana leaf and steamed.', 520.00, NULL),
(1, 'Chicken Rezala', 'A creamy, mildly spiced classic with a hint of cardamom.', 340.00, NULL),
(2, 'Prawn Coconut Curry', 'Tiger prawns simmered in coconut milk with curry leaves.', 650.00, NULL),
(2, 'Grilled Sea Bass', 'Whole sea bass grilled with lemongrass and herbs.', 780.00, NULL),
(2, 'Mango Sticky Rice', 'Sweet sticky rice with fresh mango and warm coconut cream.', 220.00, NULL),
(3, 'Mutton Sheekh', 'Hand-minced mutton kebabs grilled over charcoal.', 290.00, NULL),
(3, 'Chicken Tikka', 'Tender boneless chicken cubes in a yogurt + spice marinade.', 260.00, NULL),
(3, 'Naan with Garlic Butter', 'Tandoor-baked naan brushed with garlic butter.', 80.00, NULL);

-- a couple of reviews
INSERT INTO reviews (menu_item_id, user_id, comment) VALUES
(1, 2, 'Honestly the best bhuna I have had outside of my grandma\'s kitchen.'),
(2, 3, 'Smells incredible. Mustard was a bit strong for me but my friend loved it.'),
(7, 2, 'The kebabs at Old Town Grill are unreal. Go hungry.');

-- one food experience post
INSERT INTO food_experience_posts (user_id, title, content, post_type, restaurant_id, menu_item_id) VALUES
(2, 'A Friday lunch at Spice Route',
 'I keep coming back to this place. The beef bhuna here genuinely tastes like something out of a home kitchen. The staff remembered our order from last time. Highly recommended for a slow weekend lunch.',
 'both', 1, 1);

-- one comment on that post
INSERT INTO food_experience_comments (post_id, user_id, comment) VALUES
(1, 3, 'Agreed, the rezala is also worth trying!');
