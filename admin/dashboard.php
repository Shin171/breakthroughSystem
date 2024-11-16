<?php include('header.php'); ?>
<?php include('session.php'); ?>
<body>
    <?php include('navbar.php'); ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <?php include('sidebar_dashboard.php'); ?>
            <!--/span-->
            <div class="span9" id="content">
                <div class="row-fluid"></div>

                <div class="row-fluid">
                    <!-- block -->
                    <div id="block_bg" class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left">Data Numbers</div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="span12">
                                <!-- Existing Dashboard Data -->
                                <!-- Add your existing code for displaying data here -->

                                <!-- Bible Verse Lookup Feature -->
                                <div class="bible-lookup">
                                    <h2>Bible Verse Lookup</h2>
                                    <p>Select a Book, Chapter, and Verse:</p>
                                    <div>
                                        <label for="bookSelect">Book:</label>
                                        <select id="bookSelect" onchange="populateChapters()">
                                            <!-- Dynamically generated books -->
                                        </select>

                                        <label for="chapterSelect">Chapter:</label>
                                        <select id="chapterSelect" onchange="populateVerses()">
                                            <!-- Dynamically generated chapters -->
                                        </select>

                                        <label for="verseSelect">Verse:</label>
                                        <select id="verseSelect">
                                            <!-- Dynamically generated verses -->
                                        </select>
                                    </div>
                                    <button onclick="fetchVerse()">Get Verse</button>
                                    <div id="verseDisplay" style="margin-top: 20px; padding: 15px; border: 1px solid #ddd; background-color: #f9f9f9; border-radius: 5px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /block -->
                </div>
            </div>
        </div>
        <?php include('footer.php'); ?>
    </div>
    <?php include('script.php'); ?>
    <script>
        // Bible Books Data
        const books = [
            { name: "Genesis", chapters: 50 },
            { name: "Exodus", chapters: 40 },
            { name: "Leviticus", chapters: 27 },
            { name: "Numbers", chapters: 36 },
            { name: "Deuteronomy", chapters: 34 },
            { name: "Joshua", chapters: 24 },
            { name: "Judges", chapters: 21 },
            { name: "Ruth", chapters: 4 },
            { name: "1 Samuel", chapters: 31 },
            { name: "2 Samuel", chapters: 24 },
            { name: "1 Kings", chapters: 22 },
            { name: "2 Kings", chapters: 25 },
            { name: "1 Chronicles", chapters: 29 },
            { name: "2 Chronicles", chapters: 36 },
            { name: "Ezra", chapters: 10 },
            { name: "Nehemiah", chapters: 13 },
            { name: "Esther", chapters: 10 },
            { name: "Job", chapters: 42 },
            { name: "Psalms", chapters: 150 },
            { name: "Proverbs", chapters: 31 },
            { name: "Ecclesiastes", chapters: 12 },
            { name: "Song of Songs", chapters: 8 },
            { name: "Isaiah", chapters: 66 },
            { name: "Jeremiah", chapters: 52 },
            { name: "Lamentations", chapters: 5 },
            { name: "Ezekiel", chapters: 48 },
            { name: "Daniel", chapters: 12 },
            { name: "Hosea", chapters: 14 },
            { name: "Joel", chapters: 3 },
            { name: "Amos", chapters: 9 },
            { name: "Obadiah", chapters: 1 },
            { name: "Jonah", chapters: 4 },
            { name: "Micah", chapters: 7 },
            { name: "Nahum", chapters: 3 },
            { name: "Habakkuk", chapters: 3 },
            { name: "Zephaniah", chapters: 3 },
            { name: "Haggai", chapters: 2 },
            { name: "Zechariah", chapters: 14 },
            { name: "Malachi", chapters: 4 },
            { name: "Matthew", chapters: 28 },
            { name: "Mark", chapters: 16 },
            { name: "Luke", chapters: 24 },
            { name: "John", chapters: 21 },
            { name: "Acts", chapters: 28 },
            { name: "Romans", chapters: 16 },
            { name: "1 Corinthians", chapters: 16 },
            { name: "2 Corinthians", chapters: 13 },
            { name: "Galatians", chapters: 6 },
            { name: "Ephesians", chapters: 6 },
            { name: "Philippians", chapters: 4 },
            { name: "Colossians", chapters: 4 },
            { name: "1 Thessalonians", chapters: 5 },
            { name: "2 Thessalonians", chapters: 3 },
            { name: "1 Timothy", chapters: 6 },
            { name: "2 Timothy", chapters: 4 },
            { name: "Titus", chapters: 3 },
            { name: "Philemon", chapters: 1 },
            { name: "Hebrews", chapters: 13 },
            { name: "James", chapters: 5 },
            { name: "1 Peter", chapters: 5 },
            { name: "2 Peter", chapters: 3 },
            { name: "1 John", chapters: 5 },
            { name: "2 John", chapters: 1 },
            { name: "3 John", chapters: 1 },
            { name: "Jude", chapters: 1 },
            { name: "Revelation", chapters: 22 },
        ];

        const bookSelect = document.getElementById("bookSelect");
        const chapterSelect = document.getElementById("chapterSelect");
        const verseSelect = document.getElementById("verseSelect");

        // Populate books dropdown
        function populateBooks() {
            books.forEach(book => {
                const option = document.createElement("option");
                option.value = book.name;
                option.textContent = book.name;
                bookSelect.appendChild(option);
            });
        }

        // Populate chapters based on selected book
        function populateChapters() {
            const selectedBook = books.find(book => book.name === bookSelect.value);
            chapterSelect.innerHTML = ""; // Clear previous chapters
            for (let i = 1; i <= selectedBook.chapters; i++) {
                const option = document.createElement("option");
                option.value = i;
                option.textContent = `Chapter ${i}`;
                chapterSelect.appendChild(option);
            }
            populateVerses(); // Reset verses
        }

        // Populate verses (assuming max 50 verses per chapter for simplicity)
        function populateVerses() {
            verseSelect.innerHTML = ""; // Clear previous verses
            for (let i = 1; i <= 50; i++) {
                const option = document.createElement("option");
                option.value = i;
                option.textContent = `Verse ${i}`;
                verseSelect.appendChild(option);
            }
        }

        // Fetch Bible verse from the API
        async function fetchVerse() {
            const book = bookSelect.value;
            const chapter = chapterSelect.value;
            const verse = verseSelect.value;
            const displayDiv = document.getElementById("verseDisplay");

            displayDiv.innerHTML = ""; // Clear previous content

            try {
                const response = await fetch(`https://bible-api.com/${encodeURIComponent(book)}%20${chapter}:${verse}`);
                const data = await response.json();

                if (response.ok) {
                    displayDiv.innerHTML = `
                        <h3>${data.reference}</h3>
                        <p>${data.text}</p>
                        <small><em>${data.translation_name}</em></small>
                    `;
                } else {
                    displayDiv.textContent = data.error || "Verse not found. Please try again.";
                }
            } catch (error) {
                console.error("Error fetching verse:", error);
                displayDiv.textContent = "An error occurred. Please try again later.";
            }
        }

        // Initial population
        populateBooks();
        populateChapters();
    </script>

    <!--/span-->
                <div class="span9" id="content">
						<div class="row-fluid"></div>

                    <div class="row-fluid">
            
                        <!-- block -->
                        <div id="block_bg" class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Data Numbers</div>
                            </div>
                            <div class="block-content collapse in">
							        <div class="span12">
						
									<?php 
								$query_reg_teacher = mysqli_query($conn,"select * from teacher where teacher_status = 'Registered' ")or die(mysqli_error());
								$count_reg_teacher = mysqli_num_rows($query_reg_teacher);
								?>
								
                                <div class="span3">
                                    <div class="chart" data-percent="<?php echo $count_reg_teacher; ?>"><?php echo $count_reg_teacher; ?></div>
                                    <div class="chart-bottom-heading"><strong>Registered Teacher</strong>

                                    </div>
                                </div>
								
								<?php 
								$query_teacher = mysqli_query($conn,"select * from teacher")or die(mysqli_error());
								$count_teacher = mysqli_num_rows($query_teacher);
								?>
								
								
                                <div class="span3">
                                    <div class="chart" data-percent="<?php echo $count_teacher; ?>"><?php echo $count_teacher ?></div>
                                    <div class="chart-bottom-heading"><strong>Teachers</strong>

                                    </div>
                                </div>
								
								<?php 
								$query_student = mysqli_query($conn,"select * from student where status='Registered'")or die(mysqli_error());
								$count_student = mysqli_num_rows($query_student);
								?>
								
                                <div class="span3">
                                    <div class="chart" data-percent="<?php echo $count_student ?>"><?php echo $count_student ?></div>
                                    <div class="chart-bottom-heading"><strong>Registered Students</strong>

                                    </div>
                                </div>
								
								
										<?php 
								$query_student = mysqli_query($conn,"select * from student")or die(mysqli_error());
								$count_student = mysqli_num_rows($query_student);
								?>
								
                                <div class="span3">
                                    <div class="chart" data-percent="<?php echo $count_student ?>"><?php echo $count_student ?></div>
                                    <div class="chart-bottom-heading"><strong>Students</strong>

                                    </div>
                                </div>
								
								
								
								
							
								
									<?php 
								$query_class = mysqli_query($conn,"select * from class")or die(mysqli_error());
								$count_class = mysqli_num_rows($query_class);
								?>
								
                                <div class="span3">
                                    <div class="chart" data-percent="<?php echo $count_class; ?>"><?php echo $count_class; ?></div>
                                    <div class="chart-bottom-heading"><strong>Class</strong>

                                    </div>
                                </div>
								
								
										<?php 
								$query_file = mysqli_query($conn,"select * from files")or die(mysqli_error());
								$count_file = mysqli_num_rows($query_file);
								?>
								
                                <div class="span3">
                                    <div class="chart" data-percent="<?php echo $count_file; ?>"><?php echo $count_file; ?></div>
                                    <div class="chart-bottom-heading"><strong>Downloadable File</strong>

                                    </div>
                                </div>
								
								
										<?php 
								$query_subject = mysqli_query($conn,"select * from subject")or die(mysqli_error());
								$count_subject = mysqli_num_rows($query_subject);
								?>
								
                                <div class="span3">
                                    <div class="chart" data-percent="<?php echo $count_subject; ?>"><?php echo $count_subject; ?></div>
                                    <div class="chart-bottom-heading"><strong>Subjects</strong>

                                    </div>
                                </div>
						
						
                            </div>
                        </div>
                        <!-- /block -->
						
                    </div>
                    </div>
                
                </div>
</body>
</html>
