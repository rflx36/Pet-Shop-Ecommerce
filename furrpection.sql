-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2023 at 03:15 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `furrpection`
--

-- --------------------------------------------------------

--
-- Table structure for table `fp_admin`
--

CREATE TABLE `fp_admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(50) NOT NULL,
  `admin_password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fp_admin`
--

INSERT INTO `fp_admin` (`admin_id`, `admin_name`, `admin_password`) VALUES
(1, 'admin', '123');

-- --------------------------------------------------------

--
-- Table structure for table `fp_products`
--

CREATE TABLE `fp_products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_cost` int(11) NOT NULL,
  `product_info` varchar(255) NOT NULL,
  `product_details` text NOT NULL,
  `product_category` varchar(50) NOT NULL,
  `product_image_1` varchar(60) NOT NULL,
  `product_ratings` int(11) NOT NULL,
  `product_ratings_total` int(11) NOT NULL,
  `product_stocks` int(11) NOT NULL,
  `product_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fp_products`
--

INSERT INTO `fp_products` (`product_id`, `product_name`, `product_cost`, `product_info`, `product_details`, `product_category`, `product_image_1`, `product_ratings`, `product_ratings_total`, `product_stocks`, `product_status`) VALUES
(16, 'ZippyPaws - 3 Chirstmas Skinny Peltz Dog Toys', 499, 'Dogs will have hours of fun playing with 3 adorable woodland creatures such as the fox, raccoon, and squirrel. ', 'Target<!/r>Dog<!/r>Theme<!/r>Animals<!/r>Brand<!/r>ZippyPaws<!/r>Color<!/r>Orange, Gray, Brown<!/r>', 'Toys', '6571faf75e29b.png', 0, 0, 0, 'available'),
(17, 'ZippyPaws - 3 Halloween Skinny Peltz Dog Toys', 499, 'The perfect Halloween themed toys for including your dog in all the fun of spooky season. Get playing with 3 scary cute friends - Zombie Fox, Franken-, & Witch Cat.', 'Target<!/r>Dog<!/r>Theme<!/r>Animal<!/r>Brand<!/r>ZippyPaws<!/r>Color<!/r>Orange, Green, Black<!/r>', 'Toys', '6571fb72d805c.png', 0, 0, 0, 'available'),
(18, 'ZippyPaws - 3 Skinny Peltz Dog Toys', 399, 'This toys provide your dogs hours of fun. Dogs can chew these toys for hours, dogs will not pay attention to your shoes, clothes and other furnitures.', 'Target<!/r>Dog<!/r>Theme<!/r>Animal<!/r>Brand<!/r>ZippyPaws<!/r>Color<!/r>Brown, Gray<!/r>', 'Toys', '6571fd96f27c7.png', 0, 0, 0, 'available'),
(19, '5pcs Catnip Toys - Multicolor #1', 399, 'We choose the more breathable fabric to allow your cats smell the catnip easily and make your cats be more interested in playing with them.', 'Target<!/r>Cat<!/r>Material<!/r>Catnip<!/r>Brand<!/r>MYXIAO<!/r>Color<!/r>Orange, Black, Red, White, Pink<!/r>', 'Toys', '6571fee2619eb.png', 0, 0, 0, 'available'),
(20, '64inch Large Cat Tree - Lime', 4999, 'The multi-level cat tree is composed of good quality particle board with skin-friendly plush covering, reinforced posts are wrapped with natural sisal rope for cats to scratch', 'Target<!/r>Cat<!/r>Dimensions<!/r>40L x 50W x 150H centimeters<!/r>Brand<!/r>Beauenty<!/r>Color<!/r>Lime<!/r>', 'Toys', '657200d710091.png', 0, 0, 0, 'available'),
(21, 'Cat Toy Roller 3-Level Towers', 149, 'The tower cat toy consists of 3 tracks, with 1 colorful ball in random color in each level. The rolling ball will attract the cat’s attention', 'Target<!/r>Cat<!/r>Theme<!/r>Sport<!/r>Brand<!/r>Scent House<!/r>Material<!/r>Plastic<!/r>Features<!/r>Portable, Lightweight<!/r>', 'Toys', '6572ed2d9dd08.png', 0, 0, 0, 'available'),
(22, 'Chuckit! - Indoor Ball Dog Toy', 199, 'At 4.7 inches in diameter, this durable dog ball plush dog toy is slightly larger than a softball, featuring a lightweight design that protects surfaces in the home.', 'Target<!/r>Dog<!/r>Theme<!/r>Sport<!/r>Brand<!/r>Chuckit<!/r>Toy Type<!/r>Ball<!/r>', 'Toys', '6572eded456af.png', 0, 0, 0, 'available'),
(23, 'UPSKY - Dog Rope Toy - Pink & Green', 149, ' UPSKY dog chew toys are made of 100% natural washable cotton, free of odors and chemical dyes.', 'Target<!/r>Dog<!/r>Theme<!/r>Animal<!/r>Brand<!/r>UPSKY<!/r>Color<!/r>Pink, Green<!/r>', 'Toys', '6573f81a6eb03.png', 0, 0, 0, 'available'),
(24, 'ACANA - Dry Dog Food Light-Fit Recipe', 1500, 'Balances protein-rich animal ingredients, whole fruit and nutritious vegetables help your dog maintain a healthy weight.', 'Target<!/r>Dog<!/r>Flavor<!/r>Light-Fit<!/r>Brand<!/r>ACANA<!/r>Age Range (description)<!/r>Adult<!/r>', 'Foods', '6573f9710427b.png', 0, 0, 0, 'available'),
(25, 'ACANA - Dry Dog Food Red Meat Recipe', 1500, 'Balances protein-rich animal ingredients, whole fruit and nutritious vegetables help your dog maintain a healthy weight.', 'Target<!/r>Dog<!/r>Flavor<!/r>Red Meat<!/r>Brand<!/r>ACANA<!/r>Age Range<!/r>Adult<!/r>', 'Foods', '6573f9f145ef1.png', 0, 0, 0, 'available'),
(26, 'ACANA - Dry Dog Food Free-Run Recipe', 1500, 'Contains added Vitamin E to support a healthy immune system and naturally occurring Omega-3 and Omega-6 fatty acids to support healthy skin and a shiny coat.', 'Target<!/r>Dog<!/r>Flavor<!/r>Free-Run<!/r>Brand <!/r>ACANA<!/r>Age Range<!/r>Adult<!/r>', 'Foods', '6573fa6c489f8.png', 0, 0, 0, 'available'),
(27, 'ACANA - Dry Dog Food Freshwater Fish Blend', 1500, 'A freeze dried dog food coating made of cod adds rich flavor dogs crave, while antioxidant-rich ingredients plus added Vitamin E help support a healthy immune system.', 'Target<!/r>Dog<!/r>Flavor<!/r>Freshwater Fish Blend<!/r>Brand <!/r>ACANA<!/r>Age Range<!/r>Adult<!/r>', 'Foods', '6573fb159a9ba.png', 0, 0, 0, 'available'),
(28, 'ACANA - Wet Dog Food Duck Recipe', 999, 'The first 3 ingredients are fresh or raw duck, duck broth and turkey bone broth.', 'Target<!/r>Dog<!/r>Flavor<!/r>Duck Recipe<!/r>Brand<!/r>Acana<!/r>Food Type<!/r>Wet<!/r>', 'Foods', '6573fc422f6cc.png', 0, 0, 0, 'available'),
(29, 'ACANA - Wet Dog Food Lamb Recipe', 1000, 'Our Lamb Recipe in Bone Broth is crafted with 85%* animal ingredients in the form of premium chunks of lamb.', 'Target<!/r>Dog<!/r>Flavor<!/r>Lamb Recipe<!/r>Brand<!/r>ACANA<!/r>Food Type <!/r>Wet<!/r>', 'Foods', '6573fceb45aa8.png', 0, 0, 0, 'available'),
(30, 'ACANA - Wet Dog Food', 1000, 'Our Pork Recipe in Bone Broth is crafted with 85%* animal ingredients in the form of premium chunks of pork.', 'Target<!/r>Dog<!/r>Flavor<!/r>Pork Recipe<!/r>Brand<!/r>ACANA<!/r>Food Type<!/r>Wet<!/r>', 'Foods', '6573fd52c744f.png', 0, 0, 0, 'available'),
(31, 'ACANA - Wet Dog Food Poultry Recipe', 1000, ' Our Poultry Recipe in Bone Broth is crafted with 85%* animal ingredients including premium chunks of poultry.', 'Target<!/r>Dog<!/r>Flavor<!/r>Poultry Recipe<!/r>Brand<!/r>ACANA<!/r>Food Type<!/r>Wet<!/r>', 'Foods', '6573fd8c852a7.png', 0, 0, 0, 'available'),
(32, 'Nothing Else - Dog Food Salmon (Can of 12)', 1599, 'One Ingredient – Nothing Else. New loaf-in-gravy texture. Unlike any other product on shelves. BPA-Free Cans, No Grains, No Glutens, No Gums.', 'Target<!/r>Dog<!/r>Flavor<!/r>Salmon<!/r>Brand<!/r>Nothing Else<!/r>Food Type<!/r>Wet<!/r>', 'Foods', '6573fe9f0d484.png', 0, 0, 0, 'available'),
(33, 'Nothing Else- Wet Dog Food Duck (Can of 12)', 1599, 'One Ingredient – Nothing Else. New loaf-in-gravy texture. Unlike any other product on shelves. BPA-Free Cans, No Grains, No Glutens, No Gums.', 'Target<!/r>Dog<!/r>Flavor <!/r>Duck<!/r>Brand<!/r>Nothing Else<!/r>Food Type<!/r> <!/r>', 'Foods', '6573ff1c132c9.png', 0, 0, 0, 'available'),
(34, 'Nothing Else - Wet Dog Food Beef (Can of 12)', 1599, 'One Ingredient – Nothing Else. New loaf-in-gravy texture. Unlike any other product on shelves. BPA-Free Cans, No Grains, No Glutens, No Gums.', 'Target<!/r>Dog<!/r>Flavor<!/r>Beef<!/r>Brand<!/r>Nothing Else<!/r>Food Type <!/r>Wet<!/r>', 'Foods', '6573ff6eb88ec.png', 0, 0, 0, 'available'),
(35, 'Nothing Else- Wet Dog Food Chicken (Can of 12)', 1599, 'One Ingredient – Nothing Else. New loaf-in-gravy texture. Unlike any other product on shelves. BPA-Free Cans, No Grains, No Glutens, No Gums', 'Target<!/r>Dog<!/r>Flavor<!/r>Chicken<!/r>Brand<!/r>Nothing Else<!/r>Food Type <!/r>Wet<!/r>', 'Foods', '6573ffd1c5dbb.png', 0, 0, 0, 'available'),
(36, 'Fancy Feast - Wet Cat Food Chicken Feast in Gravy ', 1899, 'Fancy Feast senior wet cat food featuring real chicken and made without artificial colors or preservatives.', 'Target<!/r>Cat<!/r>Flavor<!/r>Chicken Feast in Gravy Minced<!/r>Brand<!/r>Fancy Feast<!/r>Food Type<!/r>Wet<!/r>', 'Foods', '657401f791060.png', 0, 0, 0, 'available'),
(37, 'Fancy Feast - Wet Cat Food Tuna Feast in Gravy', 1899, 'Fancy Feast Grilled Tuna Feast in Gravy 85g Cat Wet Food contains slow-cooked cuts of tuna, basted in savory gravy', 'Target<!/r>Cat<!/r>Flavor<!/r>Tuna Feast in Gravy<!/r>Brand<!/r>Fancy Feast<!/r>Food Type<!/r>Wet<!/r>', 'Foods', '6574035c1dc99.png', 0, 0, 0, 'available'),
(38, 'Bedsure Orthopedic - Dog Bed Black', 899, 'Our orthopedic dog sofa is designed to give your pet unparalleled support for a deep, dreamy sleep.', 'Target<!/r>Dog<!/r>Color<!/r>Black<!/r>Brand<!/r>Bedsure <!/r>Material<!/r>Polyester<!/r>', 'Beds', '6574050dcb30e.png', 0, 0, 0, 'available'),
(39, 'Bedsure Orthopedic - Dog Bed Brown', 899, 'Our orthopedic dog sofa is designed to give your pet unparalleled support for a deep, dreamy sleep.', 'Target<!/r>Dog<!/r>Color<!/r>Brown<!/r>Brand <!/r>Bedsure<!/r>Material<!/r>Polyester<!/r>', 'Beds', '65740581cde7c.png', 0, 0, 0, 'available'),
(40, 'Bedsure Orthopedic - Dog Bed Caramel', 899, 'Our orthopedic dog sofa is designed to give your pet unparalleled support for a deep, dreamy sleep.', 'Target<!/r>Dog<!/r>Color<!/r>Caramel<!/r>Brand<!/r>Bedsure<!/r>Material<!/r>Polyester<!/r>', 'Beds', '657405bebcad8.png', 0, 0, 0, 'available'),
(41, 'Bedsure Orthopedic - Dog Bed Gray', 899, 'Our orthopedic dog sofa is designed to give your pet unparalleled support for a deep, dreamy sleep.', 'Target<!/r>Dog<!/r>Color<!/r>Gray<!/r>Brand<!/r>Bedsure<!/r>Material<!/r>Polyester<!/r>', 'Beds', '6574061611f1c.png', 0, 0, 0, 'available'),
(42, 'Arabest - Long Grooming Brush - Blue', 250, 'Our dog bath brush is made of quality food grade silicone, which has the advantage of easy to clean, and quick-drying.', 'Target<!/r>Cat, Dog<!/r>Color<!/r>Blue<!/r>Brand<!/r>Arabest<!/r>Material<!/r>Silicone<!/r>', 'Grooming', '657407846481d.png', 0, 0, 0, 'available'),
(43, 'Arabest - Long Grooming Brush - Green', 250, 'Our dog bath brush is made of quality food grade silicone, which has the advantage of easy to clean, and quick-drying', 'Target<!/r>Cat, Dog<!/r>Color<!/r>Green<!/r>Brand<!/r>Arabest<!/r>Material<!/r>Silicone<!/r>', 'Grooming', '657407e3e1b4c.png', 0, 0, 0, 'available'),
(44, 'Arabest - Long Grooming Brush - Orange', 250, 'Our dog bath brush is made of quality food grade silicone, which has the advantage of easy to clean, and quick-drying', 'Target<!/r>Cat, Dog<!/r>Color<!/r>Orange<!/r>Brand<!/r>Arabest<!/r>Material<!/r>Silicone<!/r>', 'Grooming', '6574083016b27.png', 0, 0, 0, 'available'),
(45, 'Araberst- Long Grooming Brush - Pink', 599, 'Our dog bath brush is made of quality food grade silicone, which has the advantage of easy to clean, and quick-drying', 'Target<!/r>Cat, Dog<!/r>Color<!/r>Pink<!/r>Brand <!/r>Arabest<!/r>Material<!/r>Silicone<!/r>', 'Grooming', '6574086f4f945.png', 0, 0, 0, 'available'),
(46, 'Kaket - Cat Collar 6pcs Black', 330, 'The cat collar adopts a breakaway safety release buckle, easy to open and close, and the round cat ear design prevents your cat from being hurt.', 'Target<!/r>Cat<!/r>Color<!/r>Black<!/r>Brand<!/r>Kaket<!/r>Material<!/r>Polyvinyl, Chloride, Polypropylene<!/r>', 'Accessories', '6574099b0532c.png', 0, 0, 0, 'available'),
(47, 'Kaket - Cat Collar 6pcs Blue', 330, 'The cat collar adopts a breakaway safety release buckle, easy to open and close, and the round cat ear design prevents your cat from being hurt.', 'Target<!/r>Cat<!/r>Color<!/r>Blue<!/r>Brand<!/r>Kaket<!/r>Material <!/r>Polyvinyl, Chloride, Polypropylene<!/r>', 'Accessories', '657409ff5bed2.png', 0, 0, 0, 'available'),
(48, 'Kaket - Cat Collar 6pcs Green', 330, 'The cat collar adopts a breakaway safety release buckle, easy to open and close, and the round cat ear design prevents your cat from being hurt.', 'Target<!/r>Cat<!/r>Color<!/r>Green<!/r>Brand<!/r>Kaket<!/r>Material<!/r>Polyvinyl, Chloride, Polypropylene<!/r>', 'Accessories', '65740a4b79a58.png', 0, 0, 0, 'available'),
(49, 'Kaket- Cat Collar 6pcs Multicolor', 330, 'The cat collar adopts a breakaway safety release buckle, easy to open and close, and the round cat ear design prevents your cat from being hurt.', 'Target<!/r>Cat<!/r>Color<!/r>Red, Orange, Green, Blue, Pink, Black<!/r>Brand<!/r>Kaket<!/r>Material<!/r>Polyvinyl, Chloride, Polypropylene<!/r>', 'Accessories', '65740aa2c4fff.png', 0, 0, 0, 'available'),
(50, 'Temptations Tempting Tuna Flavour 75g Cat Treats', 130, 'TEMPTATIONS Treats for Cats are crunchy on the outside with an irresistibly soft, meaty center.\r\n\r\nA shake of the bag is all it takes to make your cat come running!', '', 'Treats', '65740ba3a2a17.jpg', 0, 0, 0, 'available'),
(51, 'Kit Cat Purr Puree - Treats Skin & Coat', 140, 'Cat treats are created by nutritionists who are cat lovers and are made with goodness of carefully selected natural ingredients which contains no added colors or preservatives', 'Target<!/r>Cat<!/r>Flavor<!/r>Skin & Coat<!/r>Brand <!/r>Kit Cat Purr Puree<!/r>Food Type<!/r>Treat<!/r>', 'Treats', '65740cca10d8c.png', 0, 0, 0, 'available'),
(52, 'Kit Cat Purr Pure - Chicken & Fiber', 140, 'Cat treats are created by nutritionists who are cat lovers and are made with goodness of carefully selected natural ingredients which contains no added colors or preservatives', 'Target<!/r>Cat<!/r>Flavor<!/r>Chicken & Fiber<!/r>Brand<!/r>Kit Cat Purr Pure <!/r>Food Type<!/r>Treat<!/r>', 'Treats', '65740d2aede03.png', 0, 0, 0, 'available'),
(53, 'Kit Cat Purr Pure - Treats Chicken & Salmon', 140, 'The smooth blend of tuna and fish oil recipe is perfect for cats of all life stages. ', 'Target<!/r>Cat<!/r>Flavor<!/r>Chicken & Salmon<!/r>Brand<!/r>Kit Cat Purr Pure<!/r>Food Type <!/r>Treat<!/r>', 'Treats', '65740db39a160.png', 0, 0, 0, 'available'),
(54, 'Kit Cat Purr Pure- Treats Tuna Scallop', 140, 'This recipe contains a smooth blend of tuna & scallop.', 'Target<!/r>Cat<!/r>Flavor<!/r>Treats Tuna Scallop<!/r>Brand<!/r>Kit Cat Purr Pure<!/r>Food Type<!/r>Treats<!/r>', 'Treats', '65740e3bd1953.png', 0, 0, 0, 'available'),
(55, 'Brit Vitamins 150g Grain-Free For Puppy', 930, 'Brit Vitamins 150g Grain-Free For Puppy is a functional semi-moist supplementary dog food that promotes healthy growth and development. ', 'Target<!/r>Dog<!/r>Recommended<!/r>Puppy<!/r>Brand<!/r>Brit<!/r>Size<!/r>150g<!/r>', 'Health & Wellness', '65740fbb79e4f.png', 0, 0, 0, 'available'),
(56, 'Brit Vitamins Calm 150g Grain-Free For Dogs', 800, 'Brit Vitamins Calm 150g Grain-Free For Dogs is a functional semi-moist supplemental dog food to help in stressful situations.', 'Target<!/r>Dog<!/r>Type<!/r>Calm<!/r>Brand<!/r>Brit<!/r>Size<!/r>150g<!/r>', 'Health & Wellness', '65741021ae2c7.png', 0, 0, 0, 'available'),
(57, 'Brit Vitamins Mobility 150g Grain-Free For Dogs', 930, 'Brit Vitamins Mobility 150g Grain-Free For Dogs is a functional semi-moist supplementary dog food to maintain healthy bones and joints', 'Target<!/r>Dog<!/r>Type<!/r>Mobility<!/r>Brand<!/r>Brit<!/r>Size<!/r>150g<!/r>', 'Health & Wellness', '6574105f13795.png', 0, 0, 0, 'available'),
(58, 'Chuckit! - Indoor Fumbler Dog Toy\r\n', 200, 'At 4.7 inches in diameter, this durable dog ball plush dog toy is slightly larger than a softball, featuring a lightweight design that protects surfaces in the home.', 'Target <!/r>Dog<!/r>Theme<!/r>Sport<!/r>Brand<!/r>Chuckit<!/r>Toy Type<!/r>Fumbler<!/r>', 'Toys', '6577542c6b93f.png', 0, 0, 0, 'available'),
(59, 'Chuckit! - Indoor Roller Dog Toy', 200, 'At 4.7 inches in diameter, this durable dog ball plush dog toy is slightly larger than a softball, featuring a lightweight design that protects surfaces in the home.', 'Target<!/r>Dog<!/r>Them<!/r>Sport<!/r>Brand<!/r>Chuckit<!/r>Toy Type<!/r>Roller<!/r>', 'Toys', '65775473434a7.png', 0, 0, 0, 'available'),
(60, 'Chuckit! - Indoor Tumble Dog Toy', 200, 'At 4.7 inches in diameter, this durable dog ball plush dog toy is slightly larger than a softball, featuring a lightweight design that protects surfaces in the home.', 'Target<!/r>Dog<!/r>Them<!/r>Sport<!/r>Brand<!/r>Chuckit<!/r>Toy Type<!/r>Tumble<!/r>', 'Toys', '657754b259c66.png', 0, 0, 0, 'available'),
(61, 'UPSKY - Dog Rope Toy - Green & Blue', 150, 'UPSKY dog chew toys are made of 100% natural washable cotton, free of odors and chemical dyes.', 'Target<!/r>Dog<!/r>Theme<!/r>Animal<!/r>Brand<!/r>UPSKY<!/r>Color<!/r>Green, Blue<!/r>', 'Toys', '6577552f6bc4b.png', 0, 0, 0, 'available'),
(62, 'UPSKY - Dog Rope Toy - Christmas', 160, 'UPSKY dog chew toys are made of 100% natural washable cotton, free of odors and chemical dyes.', 'Target<!/r>Dog<!/r>Theme<!/r>Animal<!/r>Brand<!/r>UPSKY<!/r>Color<!/r>Christmas<!/r>', 'Toys', '6577556f2651c.png', 0, 0, 0, 'available'),
(63, 'UPSKY - Dog Rope Toy - Purple & Pink', 150, 'UPSKY dog chew toys are made of 100% natural washable cotton, free of odors and chemical dyes.', 'Target<!/r>Dog<!/r>Theme<!/r>Animal<!/r>Brand<!/r>UPSKY<!/r>Color<!/r>Purple, Pink<!/r>', 'Toys', '657755d2ac2e9.png', 0, 0, 0, 'available'),
(64, 'Epesiri - Dog Spiked Collar - Blue', 169, 'With the studded collar on, your pets could not be bitted around the neck or destroy the collar because of the spikes.', 'Target<!/r>Dog<!/r>Color<!/r>Blue<!/r>Brand<!/r>Epesiri<!/r>Material <!/r>Faux Leather<!/r>', 'Accessories', '6577567eac791.png', 0, 0, 0, 'available'),
(65, 'Epesiri - Dog Spiked Collar - Green', 169, 'With the studded collar on, your pets could not be bitted around the neck or destroy the collar because of the spikes.', 'Target<!/r>Dog<!/r>Color<!/r>Green<!/r>Brand<!/r>Epesiri<!/r>Material<!/r>Faux Leather<!/r>', 'Accessories', '657756ae16c3c.png', 0, 0, 0, 'available'),
(66, 'Epesiri - Dog Spiked Collar - Red', 169, 'With the studded collar on, your pets could not be bitted around the neck or destroy the collar because of the spikes.', 'Target<!/r>Dog<!/r>Color<!/r>Red<!/r>Brand<!/r>Epesiri<!/r>Material<!/r>Faux Leather<!/r>', 'Accessories', '6577571248479.png', 0, 0, 0, 'available'),
(67, 'AIDIAM - Dog Grooming Kit / Low Noise', 2000, 'Traditional home grooming tools bring about a lot of mess and hair in the home.', 'Target <!/r>Cat, Dog<!/r>Color<!/r>White<!/r>Brand<!/r>AIDIAM<!/r>Hair Type<!/r>All<!/r>', 'Grooming', '657758102c2c9.png', 0, 0, 0, 'available'),
(68, 'Perperqer - Dog Nail Clipper', 299, 'Candure dog nail cutter is professionally designed for claw cut.', 'Target<!/r>Dog<!/r>Color<!/r>Dark Blue<!/r>Brand<!/r>Perperqer<!/r>Pet Size<!/r>Medium to Large<!/r>', 'Grooming', '657758aa64989.png', 0, 0, 0, 'available'),
(69, 'Pettycare - Dog Crate - Black', 999, 'Provides a safe, comfortable dwelling for your pet and can be folded down in seconds and no tools needed.', 'Target<!/r>Dog<!/r>Color<!/r>Black<!/r>Brand<!/r>Pettycare<!/r>Dimensions<!/r>36\"L x 25\"W x 25\"H<!/r>', 'Beds', '6577595cc5214.png', 0, 0, 0, 'available'),
(70, 'Pettycare- Dog Crate- Brown', 999, 'Provides a safe, comfortable dwelling for your pet and can be folded down in seconds and no tools needed.', 'Target<!/r>Dog<!/r>Color<!/r>Brown<!/r>Brand<!/r>Pettycare<!/r>Dimensions<!/r> 36\"L x 25\"W x 25\"H<!/r>', 'Beds', '657759c79f117.png', 0, 0, 0, 'available'),
(71, 'Pettycare - Dog Crate - Green', 999, 'Provides a safe, comfortable dwelling for your pet and can be folded down in seconds and no tools needed.', 'Target<!/r>Dog<!/r>Color<!/r>Green<!/r>Brand<!/r>Pettycare<!/r>Dimensions<!/r>36\"L x 25\"W x 25\"H<!/r>', 'Beds', '65775a092052d.png', 0, 0, 0, 'available'),
(72, 'Pettycare - Dog Crate - Gray', 999, 'Provides a safe, comfortable dwelling for your pet and can be folded down in seconds and no tools needed.', 'Target<!/r>Dog<!/r>Color<!/r>Gray<!/r>Brand<!/r>Pettycare<!/r>Dimensions<!/r> 36\"L x 25\"W x 25\"H<!/r>', 'Beds', '65775a428754b.png', 0, 0, 0, 'available'),
(73, 'Kuoser - Reversible Dog Jacket - Red', 499, 'The dog jackets inside are made of double layer fleece lined that will keep your lovely pet warm during the cold winter.', 'Target<!/r>Dog<!/r>Color<!/r>Red<!/r>Brand<!/r>Kuoser<!/r>Neck Size<!/r>15 inches<!/r>', 'Accessories', '65775b8b1a98a.png', 0, 0, 0, 'available'),
(74, 'Kuoser - Reversible Dog Jacket - Blue', 499, 'The dog jackets inside are made of double layer fleece lined that will keep your lovely pet warm during the cold winter.', 'Target<!/r>Dog<!/r>Color<!/r>Blue<!/r>Brand<!/r>Kuoser<!/r>Neck Size<!/r>15 inches<!/r>', 'Accessories', '65775bcf971aa.png', 0, 0, 0, 'available'),
(75, 'Kuoser - Reversible Dog Jacket - Purple', 499, 'The dog jackets inside are made of double layer fleece lined that will keep your lovely pet warm during the cold winter.', 'Target<!/r>Dog<!/r>Color<!/r>Purple<!/r>Brand<!/r>Kuoser<!/r>Neck Size<!/r>15 inches<!/r>', 'Accessories', '65775c147084c.png', 0, 0, 0, 'available'),
(76, 'Absolute Holistic -  Milk Tea - Dog Treats', 45, 'Absolute holistic dental chew are uniquely shaped to act like a toothbrush to effectively scrape plaque and tartar.', 'Target<!/r>Dog<!/r>Flavor<!/r>Milk Tea<!/r>Brand<!/r>Absolute Holistic<!/r>Weigh<!/r>25g<!/r>', 'Treats', '65775d8a6cce5.png', 0, 0, 0, 'available'),
(77, 'Absolute Holistic - Charcoal - Dog Treats', 45, 'Absolute holistic dental chew are uniquely shaped to act like a toothbrush to effectively scrape plaque and tartar.', 'Target<!/r>Dog<!/r>Flavor<!/r>Charcoal<!/r>Brand<!/r>Absolute Holistic<!/r>Weigh<!/r>25g<!/r>', 'Treats', '65775ded4cf1a.jpg', 0, 0, 0, 'available'),
(78, '\r\nAbsolute Holistic - Cranberry - Dog Treats', 45, 'Absolute holistic dental chew are uniquely shaped to act like a toothbrush to effectively scrape plaque and tartar.', 'Target<!/r>Dog<!/r>Flavor<!/r>Cranberry<!/r>Brand<!/r>Absolute Holistic<!/r>Weigh<!/r>25g<!/r>', 'Treats', '65775e375a604.png', 0, 0, 0, 'available'),
(79, 'Absolute Holistic - Mint - Dog Treats', 45, 'Absolute holistic dental chew are uniquely shaped to act like a toothbrush to effectively scrape plaque and tartar.', 'Target<!/r>Dog<!/r>Flavor<!/r>Mint<!/r>Brand<!/r>Absolute Holistic<!/r>Weigh<!/r>25g<!/r>', 'Treats', '65775e7c5c670.jpg', 0, 0, 0, 'available'),
(80, 'Absolute Holistic - Peanut Butter - Dog Treats', 45, 'Absolute holistic dental chew are uniquely shaped to act like a toothbrush to effectively scrape plaque and tartar.', 'Target<!/r>Dog<!/r>Flavor<!/r>Peanut Butter<!/r>Brand<!/r>Absolute Holistic<!/r>Weigh<!/r>25g<!/r>', 'Treats', '65775eaf7fb2b.png', 0, 0, 0, 'available'),
(81, 'Pet Food Bowl - Pink', 199, 'Help prevent spills and messes with the two in one bowls and feeding mat', 'Target<!/r>Cat, Dog<!/r>Color<!/r>Pink<!/r>Brand<!/r>Gorilla Grip<!/r>Material<!/r>Stainless Steel<!/r>', 'Foods', '6577d82dd7059.png', 0, 0, 0, 'available'),
(82, 'Self Cleaning Slicker Brush', 150, 'Remove hair on bursh with ease with this Self cleaning bursh.', 'Target<!/r>Cat, Dog<!/r>Color<!/r>Blue<!/r>Brand<!/r>Petzy<!/r>Material<!/r>Plastic<!/r>', 'Grooming', '6577e7d252b39.png', 0, 0, 0, 'available'),
(83, 'Tempcore - Cat Tunnel', 999, 'Cat tunnel for your cats', 'Target<!/r>Cat<!/r>Colofr<!/r>Multicolor<!/r>', 'Toys', '65781ab10e087.png', 0, 0, 0, 'unavailable');

-- --------------------------------------------------------

--
-- Table structure for table `fp_users`
--

CREATE TABLE `fp_users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fp_users`
--

INSERT INTO `fp_users` (`user_id`, `user_name`, `user_email`, `user_password`) VALUES
(2, 'kurt', 'ApRi1lOsJhaj66m0vnb/vq3UCe43Y6GxuBegpk4OWSA=', '$2y$10$17WaYVkHoALEV9oioKPoK.Yxcs9BFm3KLFL7sPPlg3wzQKmBxHYXW'),
(3, 'heraniel', '2pKPJB2IqFx5BnL2ZP8pRGtI1qQ/rBX/fmfs7YJKhVg=', '$2y$10$r8kXs1/gawker9hxVXUD9uvJLYq03fdAXtcPw24iIPWdXwqEAYo1e'),
(4, 'mimihan', 'UD0I2P0BrXUb1IHpzw/6E+bXuiO4iuRCPjfd7nFOvrQ=', '$2y$10$U/6w5reyUgEvYYhpzlXjbeHdpYgDgljG94EvHOlqIUQLNHOOXiyM2'),
(5, 'jeyjin', 'hcy/DCJNUSTwpEF24cIyT0F25yVdbqvIN5cyNosspzM=', '$2y$10$HpwAAQ8IItZzUjHCRY.LEeIkqWC84NTeSZDkg.ZtettGBjTINbTn6'),
(6, 'jikami', '1v0F1liuwkXuuxFpBkTsLogLuQ2OW9TqCAKqAHuLpxA=', '$2y$10$gMw7vNn6dWuBoKj2lzBzVu91B/CzngfvUA42HrTf3AfohfPBZ6wIK'),
(7, 'jin', 'hcy/DCJNUSTwpEF24cIyT0F25yVdbqvIN5cyNosspzM=', '$2y$10$CTCx98AC8zt1EwoDdlZlv.fDbBSKzgt0wUW2wW9dcePHeWQvonPVm'),
(8, 'joshua', 'e7HlmZ3sANwy36+Tv6Lq7haZV7wTv3L4tCFgjC+vpu8=', '$2y$10$xm5TRVOLqsUp9U6ebDmY8.6MDho/q0JBnX6gWog7BxnHcYyt.V8PG'),
(9, 'markquinilitan10', 'f4H1tHuQNmCihAFiMYvEfZSc7OKthK+XhbWDhglYNnA=', '$2y$10$6NshbGMxvVgVteoWFL2dneKRW2ySYB.Q./C2ohfH9FXhvdpmnbQA6'),
(10, 'May Han', 'Tw27NQINhtSb1Sh2EFp73ApcdNBdnnC22AjlncALPUs=', '$2y$10$xoyJMh6mEa2fB/fCJ77PVOk/xlaDRD/quUE4ZnxcayQQpRwl0wMJS'),
(11, 'shyleon.x', 'fPa3+ArExDiYdfXn4243eDjAMN9O9DAYi7FbVWFaHzU=', '$2y$10$I0IgMaCzLSI1g7YY6SbnsOdQ/LyxEqVQJfgzzqF5gd3xJ5wRAKVXy'),
(12, 'zedrick patatag', '2QDwCW86o10QZA545B+MIbKVene8Redp63jJ5iCQ9Bw=', '$2y$10$Raytug4Wv8unzyS0A2NNUuLIQf9mre7d19Wh/hHyLoP7TA2RSNtcG');

-- --------------------------------------------------------

--
-- Table structure for table `fp_users_cart`
--

CREATE TABLE `fp_users_cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fp_users_cart`
--

INSERT INTO `fp_users_cart` (`cart_id`, `user_id`, `product_id`, `product_amount`) VALUES
(6, 2, 17, 1),
(6, 2, 18, 1),
(7, 3, 61, 1),
(8, 4, 51, 3),
(9, 5, 39, 2),
(10, 6, 78, 1),
(10, 6, 66, 1),
(10, 6, 73, 1),
(10, 6, 38, 1),
(11, 2, 17, 1),
(12, 7, 25, 1),
(12, 7, 47, 1),
(12, 7, 51, 1),
(13, 7, 56, 2),
(14, 8, 16, 1),
(15, 9, 16, 1),
(16, 10, 18, 1),
(16, 10, 17, 1),
(17, 11, 77, 2),
(17, 11, 52, 1),
(18, 12, 76, 1),
(19, 10, 16, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fp_users_transaction`
--

CREATE TABLE `fp_users_transaction` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `user_transaction_date` datetime NOT NULL,
  `user_transaction_total` int(50) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_first_name` varchar(255) NOT NULL,
  `user_last_name` varchar(255) NOT NULL,
  `user_contact` varchar(255) NOT NULL,
  `user_address_street` varchar(255) NOT NULL,
  `user_address_zip` varchar(255) NOT NULL,
  `user_address_city` varchar(255) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `p_card_number` varchar(255) NOT NULL,
  `p_expiry_date` varchar(50) NOT NULL,
  `p_cvc` varchar(255) NOT NULL,
  `transaction_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fp_users_transaction`
--

INSERT INTO `fp_users_transaction` (`transaction_id`, `user_id`, `cart_id`, `user_transaction_date`, `user_transaction_total`, `user_email`, `user_first_name`, `user_last_name`, `user_contact`, `user_address_street`, `user_address_zip`, `user_address_city`, `payment_method`, `p_card_number`, `p_expiry_date`, `p_cvc`, `transaction_status`) VALUES
(6, 2, 6, '2023-12-12 12:18:45', 900, 'ApRi1lOsJhaj66m0vnb/vq3UCe43Y6GxuBegpk4OWSA=', 'Ptdj4kDZG/VZWnf52VZbXw==', 'Kzot+boUjkh/0DU0qkStFg==', 'K73HBlJ9S3C//o1TMXMVrA==', 'KamomPZelgjstX+aitW6Vg5+MfRt6gL0IHN3SGyG12M=', 'yCpx1hWdaRBBOGSBnlvuIg==', '15N3sKUwvNjxBZg3SVmCgA==', 'Cash On Delivery', '', '', '', 'success'),
(7, 3, 7, '2023-12-12 12:30:49', 150, '2pKPJB2IqFx5BnL2ZP8pRGtI1qQ/rBX/fmfs7YJKhVg=', 'igNNnRNO+xSgOSeqeT/8qw==', '9aPesYbMW5eooFVqxFnYOg==', 'm97YlKf7GuFCRAsUOjIatA==', 'iD4Vfwx8PvRt0GIEElzqFcu4X0p8DCpbAsfSIcWnUdEUGz0/f3HzwWW6Vbx8v2RLhct2HNLz46tf5ZEGPNHfQw==', 'daGBtsz+6r3hnB4e3fDRMw==', 'WMTWbvKW8T+9IPrZeLs8xg==', 'Cash On Delivery', '', '', '', 'success'),
(8, 5, 9, '2023-12-12 12:49:45', 1798, 'hcy/DCJNUSTwpEF24cIyT0F25yVdbqvIN5cyNosspzM=', 'zPdZ50nhlRFml8srNC9ITQ==', 'HLYLrRRFmZLa7jG3bXRvow==', 'BYAj4MOFi0JSaQE4BxGy8g==', 'ZcMb9qMWBuUOEHGEq5ZmcQ==', 'daGBtsz+6r3hnB4e3fDRMw==', 'gntJsto5ds0xQZ4D83+oZA==', 'Cash On Delivery', '', '', '', 'success'),
(9, 6, 10, '2023-12-12 13:00:54', 1612, '1v0F1liuwkXuuxFpBkTsLogLuQ2OW9TqCAKqAHuLpxA=', 'ElQ3NwuOP/stnx7DTFRnPQ==', 'Gm4LTt0pzZFsjq7xQPVIbg==', 'ZGTMHoRF/UAoDkCGhIk/nQ==', 'masH4INl7tLF0+7MyfB45A==', 'daGBtsz+6r3hnB4e3fDRMw==', 'EqQ7GuqJEebWjayxqn2cWw==', 'Cash On Delivery', '', '', '', 'success'),
(10, 2, 11, '2023-12-12 13:54:47', 500, 'ApRi1lOsJhaj66m0vnb/vq3UCe43Y6GxuBegpk4OWSA=', 'iM8cGuBoeH5mEXRIpoYd+Q==', 'XJh3pu3ZC252ABZvao0gtg==', 'qo7kXi4mdy/yhJuDWPPawA==', 'asKLxUQlR+KRk0eCGWhDePt50DwAkfaAW0fkq7/MJg0=', '1Gnw+XhjjIxiubbNX0E+lA==', 'N7JRTHlx6RsdOjJ/GcQLBQ==', 'Cash On Delivery', '', '', '', 'success'),
(11, 7, 12, '2023-12-12 14:03:57', 1970, 'hcy/DCJNUSTwpEF24cIyT0F25yVdbqvIN5cyNosspzM=', 'swXel8clIOWF3sPZOl8WhA==', '9SLxWQ7aZ8Z1QV4SUU9STw==', 'EsCYMS5YLRxCQ8Crg6bG6A==', '1pPamjN0OzMHyuETm9TQXQ==', 'daGBtsz+6r3hnB4e3fDRMw==', 'gntJsto5ds0xQZ4D83+oZA==', 'Cash On Delivery', '', '', '', 'success'),
(12, 7, 13, '2023-12-12 14:10:44', 1600, 'hcy/DCJNUSTwpEF24cIyT0F25yVdbqvIN5cyNosspzM=', 'Vr54f9fkwlEUcVHYFnASOg==', '9SLxWQ7aZ8Z1QV4SUU9STw==', 'aUnmQSf7njHGlXiC1/YG4Q==', '3gZmhg2InE/2wDJhLzndUA==', 'daGBtsz+6r3hnB4e3fDRMw==', 'gntJsto5ds0xQZ4D83+oZA==', 'Cash On Delivery', '', '', '', 'rejected'),
(13, 8, 14, '2023-12-12 14:52:24', 500, 'e7HlmZ3sANwy36+Tv6Lq7haZV7wTv3L4tCFgjC+vpu8=', 'S4zxToPrnXo8HmDT2UEUWA==', 'HNNvS60QoeQSJUCamPUGgw==', 'jBbpWOerLI7kbGJvjckWiQ==', 'y6jItbe+OQP/Pv1ezAU9x8HidMqDD/2X3i3lk4Rjn+6oc9ZbdOQvo2AZbU9awcoc', 'daGBtsz+6r3hnB4e3fDRMw==', 'WMTWbvKW8T+9IPrZeLs8xg==', 'Cash On Delivery', '', '', '', 'rejected'),
(14, 9, 15, '2023-12-12 15:06:30', 500, 'f4H1tHuQNmCihAFiMYvEfZSc7OKthK+XhbWDhglYNnA=', 'NisIQnt10M9Qm5OX1ITRdg==', 'ipm8bDN+OYAoJ1i9u46SCA==', 'xzf4tt7yUv+kRucKanAS4g==', 'aykgdq0jwzqykE6jhB7YJYbVy1UGe7SgvZ84ZN7LI7ESoOjFuZ2iAOWEI6ul50ob', 'daGBtsz+6r3hnB4e3fDRMw==', 'Ef2dzIXWsfAqXzAzIEywKw==', 'Cash On Delivery', '', '', '', 'pending'),
(15, 10, 16, '2023-12-12 15:29:28', 900, 'Tw27NQINhtSb1Sh2EFp73ApcdNBdnnC22AjlncALPUs=', 'hfyZtdi3FILRCE29w8MJPg==', 'kkIrOM81HJT4CtC//k/CmA==', 'kGLVxGjZSYgVXkpDt8xRqw==', 'APNPlpQBjhTeF9zvjg4Dtnn14hSJ9xE7kBqAdPKQxUc=', 'daGBtsz+6r3hnB4e3fDRMw==', 'ZtGjOsuWee6Wb/IDToX4Og==', 'Cash On Delivery', '', '', '', 'success'),
(16, 11, 17, '2023-12-12 15:46:35', 230, 'fPa3+ArExDiYdfXn4243eDjAMN9O9DAYi7FbVWFaHzU=', '0EMnbi0aLnWG1RQKAgqq4g==', 'B6+mpml6YY/F7CB7waeI/g==', 'BUQT8poNp0LQmIsR7Bzd6A==', 'PYYY2jJVrpVLfiRABLlt6Q==', 'U335F3Cb9rdxXSB3WdgDWg==', 'pXd5q9IfMa0Hnszc44y13w==', 'Credit / Debit Card', '3oSCjsuC/Nb3WtG8n63Ojt0F8FXktJuq63gugHikDbs=', '2023-11', 'WL1yO9WZUnGiBNIpiNIl0w==', 'rejected'),
(17, 12, 18, '2023-12-12 16:29:22', 45, 'CqwTYK05YGs86tUPZhUaDyVknk+jcate0kloHWDlAzc=', '61+wHgdlddsrckUxUA0Tgw==', '3S6yInHE832oYow/gJfWjA==', 'KSiWVPnlwMlJ73fU4JEX9Q==', 'ihqiVTW089HppRbY81WTFLrelVCJ9W4eEtnk0LFzg+I=', 'daGBtsz+6r3hnB4e3fDRMw==', 'WMTWbvKW8T+9IPrZeLs8xg==', 'Cash On Delivery', '', '', '', 'pending'),
(18, 10, 19, '2023-12-13 13:30:11', 499, 'Tw27NQINhtSb1Sh2EFp73ApcdNBdnnC22AjlncALPUs=', 'r2RRrCznU2YqL4B3TD7QiA==', 'NGUE1p4N8QeJlREX3rU9tQ==', 'zzUaAaSaiBMbuF/Bo9PyfQ==', 'UatXV/jeJpkR5qQ1+0EPCA==', 'daGBtsz+6r3hnB4e3fDRMw==', 'E7uyEVORCqU8ULVIo8KrLg==', 'Cash On Delivery', '', '', '', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `fp_user_likes`
--

CREATE TABLE `fp_user_likes` (
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fp_user_likes`
--

INSERT INTO `fp_user_likes` (`user_id`, `product_id`) VALUES
(3, 17),
(3, 61),
(4, 16),
(4, 17),
(4, 18),
(4, 28);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fp_admin`
--
ALTER TABLE `fp_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `fp_products`
--
ALTER TABLE `fp_products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `fp_users`
--
ALTER TABLE `fp_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `fp_users_cart`
--
ALTER TABLE `fp_users_cart`
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `fp_users_transaction`
--
ALTER TABLE `fp_users_transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `fp_user_likes`
--
ALTER TABLE `fp_user_likes`
  ADD KEY `user_id` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fp_admin`
--
ALTER TABLE `fp_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fp_products`
--
ALTER TABLE `fp_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `fp_users`
--
ALTER TABLE `fp_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `fp_users_cart`
--
ALTER TABLE `fp_users_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `fp_users_transaction`
--
ALTER TABLE `fp_users_transaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fp_users_cart`
--
ALTER TABLE `fp_users_cart`
  ADD CONSTRAINT `fp_users_cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `fp_users` (`user_id`),
  ADD CONSTRAINT `fp_users_cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `fp_products` (`product_id`);

--
-- Constraints for table `fp_users_transaction`
--
ALTER TABLE `fp_users_transaction`
  ADD CONSTRAINT `fp_users_transaction_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `fp_users` (`user_id`);

--
-- Constraints for table `fp_user_likes`
--
ALTER TABLE `fp_user_likes`
  ADD CONSTRAINT `fp_user_likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `fp_users` (`user_id`),
  ADD CONSTRAINT `fp_user_likes_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `fp_products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
