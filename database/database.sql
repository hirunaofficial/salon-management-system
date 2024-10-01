CREATE TABLE services (
    service_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    duration INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO services (name, category, description, price, duration)
VALUES 
    -- Haircuts
    ('Classic Haircut', 'Haircuts', 'A traditional haircut that suits any style, done by our expert stylists.', 2500, 30),
    ('Layered Haircut', 'Haircuts', 'Add texture and volume with a layered cut, perfect for all hair lengths.', 3500, 45),
    ('Pixie Cut', 'Haircuts', 'A chic and stylish short cut, perfect for a modern look.', 3000, 40),
    ('Bob Cut', 'Haircuts', 'The classic bob cut, ideal for a sleek and sophisticated style.', 3200, 45),
    
    -- Styling
    ('Blowout', 'Styling', 'A professional blowout for smooth and voluminous hair.', 2000, 30),
    ('Updo Hairstyling', 'Styling', 'Perfect for special occasions, get your hair styled into a classic updo.', 4500, 60),
    ('Beach Waves', 'Styling', 'Soft, loose waves for a natural, effortless look.', 3500, 45),
    ('Braiding', 'Styling', 'Intricate braids for a polished and elegant look.', 4000, 60),
    ('Straightening', 'Styling', 'Professional hair straightening for a sleek, smooth finish.', 6000, 60),
    
    -- Hair Treatments
    ('Keratin Treatment', 'Treatments', 'A deep conditioning treatment to smooth and strengthen your hair.', 12000, 120),
    ('Hot Oil Treatment', 'Treatments', 'Nourish and revitalize dry or damaged hair with our hot oil treatment.', 4000, 45),
    ('Scalp Treatment', 'Treatments', 'A soothing treatment to cleanse and rejuvenate your scalp.', 3000, 30),
    ('Deep Conditioning', 'Treatments', 'Intensive treatment to restore moisture and shine to your hair.', 5000, 45),
    
    -- Hair Coloring
    ('Full Hair Coloring', 'Hair Coloring', 'Transform your look with a full head of vibrant color.', 7000, 90),
    ('Highlights', 'Hair Coloring', 'Add dimension and brightness with strategically placed highlights.', 9000, 120),
    ('Balayage', 'Hair Coloring', 'A freehand technique to create natural, sun-kissed highlights.', 12000, 150),
    ('Root Touch-Up', 'Hair Coloring', 'Refresh your look with a root touch-up to cover regrowth.', 4000, 60),
    
    -- Makeup
    ('Full Makeup Application', 'Makeup', 'A complete makeup look for any occasion, using high-quality products.', 6000, 60),
    ('Bridal Makeup', 'Makeup', 'Specialized bridal makeup to make you glow on your big day.', 15000, 120),
    ('Party Makeup', 'Makeup', 'Fun and glamorous makeup for any celebration.', 5000, 60);
