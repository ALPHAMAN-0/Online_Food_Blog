-- seed data for Online Food Blog
-- run AFTER schema.sql
-- default users:
--   admin@foodly.com / admin123
--   sara@foodly.com  / member123

USE online_food_blog;

-- clear in dependency order
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
 'A modern take on traditional Bengali flavors, founded in 2015 by Chef Imran. Quiet upstairs seating, slow-cooked classics and a small but excellent dessert list.',
 'Bring back home-style cooking with seasonal, locally-sourced ingredients. No shortcuts, no MSG, lots of patience.'),
('Sunset Cafe', 'Dhaka', 'Gulshan',
 'Coastal-inspired menu with fresh seafood and a relaxed terrace seating. The dim, candlelit interior makes it a favourite for slow evenings.',
 'A peaceful escape in the middle of the city with food that feels like a small holiday.'),
('Old Town Grill', 'Chittagong', 'Agrabad',
 'Charcoal grill specialty house known for slow-cooked kebabs. Run by the same family for three generations.',
 'Honest, smoky, no-fuss grilled food at a fair price.');

-- menu items with stable Unsplash photo URLs
INSERT INTO menu_items (restaurant_id, name, description, price, image_path) VALUES
(1, 'Beef Bhuna',
 'Slow-cooked beef in dark, fragrant masala. Served with steamed basmati and a side of fresh salad.',
 380.00,
 'https://images.unsplash.com/photo-1545247181-516773cae754?auto=format&fit=crop&w=900&q=80'),

(1, 'Hilsa Paturi',
 'Hilsa fish marinated in mustard paste, wrapped in banana leaf and steamed until just flaky.',
 520.00,
 'https://images.unsplash.com/photo-1626777553635-08c1d1d895f3?auto=format&fit=crop&w=900&q=80'),

(1, 'Chicken Rezala',
 'A creamy, mildly spiced classic with a hint of cardamom and a generous swirl of yogurt.',
 340.00,
 'https://images.unsplash.com/photo-1603894584373-5ac82b2ae398?auto=format&fit=crop&w=900&q=80'),

(2, 'Prawn Coconut Curry',
 'Tiger prawns simmered in coconut milk with curry leaves and a touch of tamarind.',
 650.00,
 'https://images.unsplash.com/photo-1455619452474-d2be8b1e70cd?auto=format&fit=crop&w=900&q=80'),

(2, 'Grilled Sea Bass',
 'Whole sea bass grilled with lemongrass and herbs, served with charred lemon.',
 780.00,
 'https://images.unsplash.com/photo-1467003909585-2f8a72700288?auto=format&fit=crop&w=900&q=80'),

(2, 'Mango Sticky Rice',
 'Sweet sticky rice with fresh seasonal mango and warm coconut cream.',
 220.00,
 'https://images.unsplash.com/photo-1488477181946-6428a0291777?auto=format&fit=crop&w=900&q=80'),

(3, 'Mutton Sheekh',
 'Hand-minced mutton kebabs grilled over charcoal, finished with a touch of green chili and onion.',
 290.00,
 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?auto=format&fit=crop&w=900&q=80'),

(3, 'Chicken Tikka',
 'Tender boneless chicken cubes in a yogurt + spice marinade, smoke-kissed from the tandoor.',
 260.00,
 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?auto=format&fit=crop&w=900&q=80'),

(3, 'Naan with Garlic Butter',
 'Tandoor-baked naan brushed with garlic butter and finished with coriander.',
 80.00,
 'https://images.unsplash.com/photo-1633945274405-b6c8069047b0?auto=format&fit=crop&w=900&q=80');

-- a few reviews
INSERT INTO reviews (menu_item_id, user_id, comment) VALUES
(1, 2, 'Honestly the best bhuna I have had outside of my grandma''s kitchen.'),
(2, 3, 'Smells incredible. Mustard was a bit strong for me but my friend loved it.'),
(7, 2, 'The kebabs at Old Town Grill are unreal. Go hungry.'),
(5, 3, 'Beautifully plated and worth the price. The lemongrass really comes through.');

-- one food experience post
INSERT INTO food_experience_posts (user_id, title, content, post_type, restaurant_id, menu_item_id) VALUES
(2, 'A slow Friday lunch at Spice Route',
 'I keep coming back to this place. The beef bhuna here genuinely tastes like something out of a home kitchen — patient, dark, almost smoky. The staff remembered our order from last time. Highly recommended for an unhurried weekend lunch when you want food that tastes like it was made for you.',
 'both', 1, 1);

-- one comment on that post
INSERT INTO food_experience_comments (post_id, user_id, comment) VALUES
(1, 3, 'Agreed, the rezala is also worth trying — milder but really comforting.');
