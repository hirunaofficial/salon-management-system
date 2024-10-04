
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    telephone VARCHAR(15) NOT NULL,
    fax VARCHAR(50),
    address VARCHAR(255),
    city VARCHAR(100),
    country VARCHAR(100),
    postal_code VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE user_otp (
    user_otp_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    telephone VARCHAR(15) NOT NULL,
    otp_code INT NOT NULL,
    otp_expiry DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE staff (
    staff_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    specialization VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Inserting the 3 staff members into the table:
INSERT INTO staff (first_name, last_name, email, phone, specialization) VALUES
('Amal', 'Perera', 'amal.perera@glamoursalon.com', '0711234567', 'Barber'),
('Niluka', 'Fernando', 'niluka.fernando@glamoursalon.com', '0717654321', 'Hair Stylist'),
('Sachika', 'Silva', 'sachika.silva@glamoursalon.com', '0719876543', 'Makeup Artist');

CREATE TABLE appointments (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    service_id INT NOT NULL,
    staff_id INT DEFAULT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (service_id) REFERENCES services(service_id) ON DELETE CASCADE,
    FOREIGN KEY (staff_id) REFERENCES staff(staff_id) ON DELETE SET NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE services (
    service_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    member_price DECIMAL(10, 2) NOT NULL,
    duration INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO services (name, category, description, price, member_price, duration)
VALUES 
    -- Haircuts
    ('Classic Haircut', 'Haircuts', 'A traditional haircut that suits any style, done by our expert stylists.', 2500, 2300, 30),
    ('Layered Haircut', 'Haircuts', 'Add texture and volume with a layered cut, perfect for all hair lengths.', 3500, 3200, 45),
    ('Pixie Cut', 'Haircuts', 'A chic and stylish short cut, perfect for a modern look.', 3000, 2800, 40),
    ('Bob Cut', 'Haircuts', 'The classic bob cut, ideal for a sleek and sophisticated style.', 3200, 3000, 45),
    ('Fringe Trim', 'Haircuts', 'A quick and simple trim for your bangs or fringe.', 1500, 1300, 15),
    ('Men’s Haircut', 'Haircuts', 'A clean and sharp men’s cut for a modern look.', 2200, 2000, 30),
    ('Kid’s Haircut', 'Haircuts', 'A fun and stylish haircut for children.', 1800, 1600, 30),
    
    -- Styling
    ('Blowout', 'Styling', 'A professional blowout for smooth and voluminous hair.', 2000, 1800, 30),
    ('Updo Hairstyling', 'Styling', 'Perfect for special occasions, get your hair styled into a classic updo.', 4500, 4200, 60),
    ('Beach Waves', 'Styling', 'Soft, loose waves for a natural, effortless look.', 3500, 3300, 45),
    ('Braiding', 'Styling', 'Intricate braids for a polished and elegant look.', 4000, 3800, 60),
    ('Straightening', 'Styling', 'Professional hair straightening for a sleek, smooth finish.', 6000, 5700, 60),
    ('Curls and Waves', 'Styling', 'Beautiful curls or waves for a voluminous hairstyle.', 3000, 2800, 45),
    ('Flat Iron Styling', 'Styling', 'Flat iron styling for a smooth and sleek look.', 2800, 2600, 30),
    
    -- Hair Treatments
    ('Keratin Treatment', 'Treatments', 'A deep conditioning treatment to smooth and strengthen your hair.', 12000, 11000, 120),
    ('Hot Oil Treatment', 'Treatments', 'Nourish and revitalize dry or damaged hair with our hot oil treatment.', 4000, 3800, 45),
    ('Scalp Treatment', 'Treatments', 'A soothing treatment to cleanse and rejuvenate your scalp.', 3000, 2800, 30),
    ('Deep Conditioning', 'Treatments', 'Intensive treatment to restore moisture and shine to your hair.', 5000, 4700, 45),
    ('Olaplex Treatment', 'Treatments', 'Rebuild broken hair bonds with an Olaplex treatment.', 6500, 6000, 60),
    ('Protein Hair Mask', 'Treatments', 'A protein-rich mask to strengthen weak and damaged hair.', 5500, 5300, 60),
    ('Moisturizing Hair Treatment', 'Treatments', 'Restore moisture to dry and brittle hair with this intensive treatment.', 5000, 4800, 60),
    
    -- Hair Coloring
    ('Full Hair Coloring', 'Hair Coloring', 'Transform your look with a full head of vibrant color.', 7000, 6700, 90),
    ('Highlights', 'Hair Coloring', 'Add dimension and brightness with strategically placed highlights.', 9000, 8500, 120),
    ('Balayage', 'Hair Coloring', 'A freehand technique to create natural, sun-kissed highlights.', 12000, 11500, 150),
    ('Root Touch-Up', 'Hair Coloring', 'Refresh your look with a root touch-up to cover regrowth.', 4000, 3800, 60),
    ('Ombre Coloring', 'Hair Coloring', 'A beautiful gradient from darker roots to lighter ends.', 8500, 8000, 120),
    ('Partial Highlights', 'Hair Coloring', 'Strategically placed highlights for a more subtle look.', 7000, 6700, 90),
    ('Toner Application', 'Hair Coloring', 'A toner to neutralize brassiness and enhance your color.', 2500, 2300, 30),
    
    -- Makeup
    ('Full Makeup Application', 'Makeup', 'A complete makeup look for any occasion, using high-quality products.', 6000, 5700, 60),
    ('Bridal Makeup', 'Makeup', 'Specialized bridal makeup to make you glow on your big day.', 15000, 14500, 120),
    ('Party Makeup', 'Makeup', 'Fun and glamorous makeup for any celebration.', 5000, 4800, 60),
    ('Natural Makeup Look', 'Makeup', 'A subtle and natural makeup look for daytime events.', 4000, 3800, 45),
    ('Smoky Eye Makeup', 'Makeup', 'Bold and dramatic smoky eyes for a glamorous look.', 5000, 4700, 60),
    ('Airbrush Makeup', 'Makeup', 'Flawless airbrush makeup for a smooth, camera-ready finish.', 7000, 6700, 60),
    ('Glam Makeup', 'Makeup', 'High-glamour makeup with bold colors and contouring.', 6000, 5800, 60),
    
    -- Nails
    ('Basic Manicure', 'Nails', 'A simple manicure for clean and polished nails.', 2000, 1800, 45),
    ('Basic Pedicure', 'Nails', 'A refreshing pedicure to clean and beautify your feet.', 2500, 2200, 60),
    ('Gel Manicure', 'Nails', 'Long-lasting gel polish with a high-shine finish.', 4000, 3700, 60),
    ('Acrylic Nail Extensions', 'Nails', 'Enhance your nails with acrylic extensions and your choice of color.', 5000, 4700, 90),
    ('Spa Pedicure', 'Nails', 'A luxurious pedicure with exfoliation and massage.', 3500, 3200, 75),
    ('Nail Art', 'Nails', 'Custom nail art designs for a unique and personalized look.', 3000, 2800, 45),
    ('French Manicure', 'Nails', 'A classic French manicure with a pink base and white tips.', 3500, 3300, 45),
    
    -- Waxing & Threading
    ('Eyebrow Threading', 'Waxing & Threading', 'Shape and define your eyebrows with precision threading.', 1500, 1300, 20),
    ('Full Face Threading', 'Waxing & Threading', 'Remove unwanted facial hair with gentle threading.', 3500, 3200, 40),
    ('Underarm Waxing', 'Waxing & Threading', 'Smooth and hair-free underarms with gentle waxing.', 2000, 1800, 30),
    ('Full Leg Waxing', 'Waxing & Threading', 'Get silky smooth legs with full-leg waxing.', 4500, 4200, 60),
    ('Bikini Waxing', 'Waxing & Threading', 'Gentle bikini waxing for clean and smooth results.', 4000, 3700, 45),
    ('Full Body Waxing', 'Waxing & Threading', 'Comprehensive waxing for the entire body.', 10000, 9500, 120),
    ('Upper Lip Waxing', 'Waxing & Threading', 'Quick and easy waxing for upper lip hair removal.', 1000, 800, 15);

CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    description TEXT,
    category VARCHAR(100),
    price DECIMAL(10, 2) NOT NULL,
    image_url VARCHAR(255),
    stock_status ENUM('in_stock', 'out_of_stock') DEFAULT 'in_stock',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO products (product_name, description, category, price, image_url, stock_status)
VALUES 
('Hair Shampoo', 'A nourishing shampoo for all hair types.', 'Hair Care', 16000.00, 'images/shop/1.jpg', 'in_stock'),
('Beard Trimmer', 'Precision beard trimmer for all styles.', 'Beard Care', 12800.00, 'images/shop/2.jpg', 'in_stock'),
('Hair Straightener', 'High-quality hair straightener with ceramic plates.', 'Hair Tools', 22400.00, 'images/shop/3.jpg', 'in_stock'),
('Hair Dryer', 'Powerful hair dryer for fast drying.', 'Hair Tools', 20800.00, 'images/shop/4.jpg', 'out_of_stock'),
('Hair Spray', 'Volumizing hair spray with extra hold.', 'Hair Care', 9600.00, 'images/shop/5.jpg', 'in_stock'),
('Beard Wax', 'Beard wax to style and shape facial hair.', 'Beard Care', 6400.00, 'images/shop/6.jpg', 'in_stock'),
('Hair Serum', 'Shine-enhancing serum for smooth hair.', 'Hair Care', 14400.00, 'images/shop/7.jpg', 'in_stock'),
('Hair Mask', 'Deep conditioning hair mask for damaged hair.', 'Hair Care', 11200.00, 'images/shop/8.jpg', 'in_stock'),
('Beard Oil', 'Nourishing beard oil to soften and condition.', 'Beard Care', 8000.00, 'images/shop/9.jpg', 'in_stock'),
('Hair Shining Oil', 'Adds shine and smoothness to hair.', 'Hair Care', 12800.00, 'images/shop/10.jpg', 'in_stock'),
('Electric Shaver', 'High-performance electric shaver for clean cuts.', 'Beard Tools', 27200.00, 'images/shop/11.jpg', 'out_of_stock'),
('Hair Mousse', 'Lightweight mousse for volume and texture.', 'Hair Care', 8960.00, 'images/shop/12.jpg', 'in_stock'),
('Beard Comb', 'Wooden comb designed specifically for beards.', 'Beard Tools', 4800.00, 'images/shop/13.jpg', 'in_stock'),
('Hair Clippers', 'Professional hair clippers for salon-quality cuts.', 'Hair Tools', 28800.00, 'images/shop/14.jpg', 'in_stock'),
('Hair Gel', 'Strong hold hair gel for all-day control.', 'Hair Care', 5760.00, 'images/shop/15.jpg', 'in_stock');

CREATE TABLE gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL
);

INSERT INTO gallery (title, category, file_path) VALUES 
('Classic Hair Style 1', 'hair styles', 'images/gallery/1.jpg'),
('Makeup Look 1', 'makeup', 'images/gallery/2.jpg'),
('Classic Hair Style 2', 'hair styles', 'images/gallery/3.jpg'),
('Nail Art Design 1', 'nail art', 'images/gallery/4.jpg'),
('Classic Hair Style 3', 'hair styles', 'images/gallery/5.jpg'),
('Makeup Look 2', 'makeup', 'images/gallery/6.jpg');

CREATE TABLE blog (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    image VARCHAR(255),
    post_date DATE,
    comments_count INT DEFAULT 0,
    category VARCHAR(100),
    tags VARCHAR(255)
);

INSERT INTO blog (title, content, image, post_date, comments_count, category, tags) VALUES
('The Ultimate Guide to Hair Straighteners: Choosing the Best for Your Hair', 
 'In this article, we explore the best hair straighteners on the market, how to choose one based on your hair type, and some expert tips on how to use them effectively without causing damage.', 
 'images/blog/1.jpg', '2023-09-15', 45, 'Hair Straightener', 'hair care,heat styling,tips'),

('Top 5 Hair Dryer Mistakes You Should Avoid', 
 'Hair dryers are essential for daily grooming, but are you using them correctly? This article discusses the common mistakes people make when using hair dryers and how to avoid damaging your hair.', 
 'images/blog/2.jpg', '2023-09-20', 30, 'Hair Dryer', 'hair care,blow-drying,tips'),

('Beard Grooming 101: Maintaining a Healthy Beard', 
 'Whether you are growing a short beard or a long, majestic one, maintaining it is essential. This article outlines the best beard grooming techniques, products you should use, and trimming tips.', 
 'images/blog/3.jpg', '2023-09-25', 65, 'Beard Trimmer', 'beard care,trimming,tips'),

('Hair Wax vs Gel: Which is Best for Styling Your Hair?', 
 'Are you confused about whether to use wax or gel for styling your hair? In this article, we compare the two, including their benefits and which hair types they work best for.', 
 'images/blog/4.jpg', '2023-10-01', 50, 'Hair Wax', 'styling,products,hair wax,gel')
;

CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    blog_id INT NOT NULL,
    author VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (blog_id) REFERENCES blog(id) ON DELETE CASCADE
);

CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE wishlist (
    wishlist_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    qty INT DEFAULT 1,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telephone VARCHAR(15) NOT NULL,
    address VARCHAR(255) NOT NULL,
    city VARCHAR(100) NOT NULL,
    state VARCHAR(100) NOT NULL,
    postal_code VARCHAR(20) NOT NULL,
    country VARCHAR(100) NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    payment_method ENUM('cod', 'bank_transfer') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    total DECIMAL(10, 2) AS (quantity * price) PERSISTENT,
    FOREIGN KEY (order_id) REFERENCES orders(order_id)
);