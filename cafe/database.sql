-- Create Database
CREATE DATABASE IF NOT EXISTS cafe_billing;
USE cafe_billing;

-- Menu Items Table
CREATE TABLE menu_items (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    description TEXT,
    available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Orders Table
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100),
    table_number INT,
    total_amount DECIMAL(10, 2) NOT NULL,
    payment_status ENUM('pending', 'paid') DEFAULT 'pending',
    payment_method VARCHAR(50),
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Order Items Table
CREATE TABLE  order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    item_id INT NOT NULL,
    quantity INT NOT NULL,
    item_price DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES menu_items(item_id)
);

-- Insert Sample Menu Items
INSERT INTO menu_items (item_name, category, price, description) VALUES
('Espresso', 'Coffee', 2.50, 'Strong black coffee'),
('Cappuccino', 'Coffee', 3.50, 'Espresso with steamed milk foam'),
('Latte', 'Coffee', 4.00, 'Espresso with steamed milk'),
('Americano', 'Coffee', 3.00, 'Espresso with hot water'),
('Green Tea', 'Tea', 2.00, 'Fresh green tea'),
('English Breakfast Tea', 'Tea', 2.00, 'Classic black tea'),
('Croissant', 'Pastry', 3.50, 'Buttery French pastry'),
('Chocolate Muffin', 'Pastry', 4.00, 'Rich chocolate muffin'),
('Blueberry Pancakes', 'Breakfast', 7.50, 'Fluffy pancakes with blueberries'),
('Caesar Salad', 'Salad', 8.00, 'Fresh romaine with caesar dressing'),
('Club Sandwich', 'Sandwich', 9.50, 'Triple decker sandwich'),
('Cheesecake', 'Dessert', 5.50, 'Creamy New York style cheesecake');