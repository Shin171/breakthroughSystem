<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
    <body id="class_div">
		<?php include('navbar_teacher.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('teacher_sidebar.php'); ?>
                <div class="span6" id="content">
                     <div class="row-fluid">
					    <!-- breadcrumb -->	
					     <ul class="breadcrumb">
								<?php
								$school_year_query = mysqli_query($conn,"select * from school_year order by school_year DESC")or die(mysqli_error());
								$school_year_query_row = mysqli_fetch_array($school_year_query);
								$school_year = $school_year_query_row['school_year'];
								?>
								<li><a href="#"><b>My Class</b></a><span class="divider">/</span></li>
								<li><a href="#">School Year: <?php echo $school_year_query_row['school_year']; ?></a></li>
						</ul>
						 <!-- end breadcrumb -->
                        <!-- block -->
                        <div class="block">
								<div class="navbar navbar-inner block-header">
									<div id="count_class" class="muted pull-right"></div>
                                    <div class="row-fluid">
                                        <!-- block -->
                                        <div id="block_bg" class="block">
                                            <div class="navbar navbar-inner block-header">
                                                <div class="muted pull-left">Bible Verse Lookup</div>
                                            </div>
                                            <div class="block-content collapse in">
                                                <div class="span12">
                                                    <!-- Bible Verse Lookup -->
                                                    <div class="bible-lookup">
                                                        <!-- Random Verse Display -->
                                                        <div id="randomVerse" style="margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; background-color: #f0f8ff; border-radius: 5px;">
                                                            <strong>Random Verse of the Day:</strong>
                                                            <p id="randomVerseText">Loading...</p>
                                                        </div>

                                                        <h2>Bible Verse Lookup</h2>
                                                        <p>Select a Testament, Book, Chapter, and Verse:</p>
                                                        <div>
                                                            <label for="testamentSelect">Testament:</label>
                                                            <select id="testamentSelect" onchange="populateBooks()">
                                                                <option value="">Select Testament</option>
                                                                <option value="Old">Old Testament</option>
                                                                <option value="New">New Testament</option>
                                                            </select>

                                                            <label for="bookSelect">Book:</label>
                                                            <select id="bookSelect" onchange="populateChapters()">
                                                                <option value="">Select Book</option>
                                                            </select>

                                                            <label for="chapterSelect">Chapter:</label>
                                                            <select id="chapterSelect" onchange="populateVerses()">
                                                                <option value="">Select Chapter</option>
                                                            </select>

                                                            <label for="verseSelect">Verse:</label>
                                                            <select id="verseSelect">
                                                                <option value="">Select Verse</option>
                                                            </select>
                                                        </div>

                                                        <div style="margin-top: 10px;">
                                                            <button onclick="fetchVerse()">Get Verse</button>
                                                            <button onclick="fetchChapter()">View Chapter</button>

                                                        </div>
                                                        <div id="verseDisplay" style="margin-top: 20px; padding: 15px; border: 1px solid #ddd; background-color: #f9f9f9; border-radius: 5px;">
                                                        </div>
                                                    </div>
                                                </div>



                                </div>
                        </div>
                         <?php include('footer.php'); ?>
                     </div>
                    <?php include('script.php'); ?>
                    <script>
                        // Bible Books Data
                        const books = [
                            { name: "Genesis", chapters: 50, testament: "Old" },
                            { name: "Exodus", chapters: 40, testament: "Old" },
                            { name: "Leviticus", chapters: 27, testament: "Old" },
                            { name: "Numbers", chapters: 36, testament: "Old" },
                            { name: "Deuteronomy", chapters: 34, testament: "Old" },
                            { name: "Joshua", chapters: 24, testament: "Old" },
                            { name: "Judges", chapters: 21, testament: "Old" },
                            { name: "Ruth", chapters: 4, testament: "Old" },
                            { name: "1 Samuel", chapters: 31, testament: "Old" },
                            { name: "2 Samuel", chapters: 24, testament: "Old" },
                            { name: "1 Kings", chapters: 22, testament: "Old" },
                            { name: "2 Kings", chapters: 25, testament: "Old" },
                            { name: "1 Chronicles", chapters: 29, testament: "Old" },
                            { name: "2 Chronicles", chapters: 36, testament: "Old" },
                            { name: "Ezra", chapters: 10, testament: "Old" },
                            { name: "Nehemiah", chapters: 13, testament: "Old" },
                            { name: "Esther", chapters: 10, testament: "Old" },
                            { name: "Job", chapters: 42, testament: "Old" },
                            { name: "Psalms", chapters: 150, testament: "Old" },
                            { name: "Proverbs", chapters: 31, testament: "Old" },
                            { name: "Ecclesiastes", chapters: 12, testament: "Old" },
                            { name: "Song of Songs", chapters: 8, testament: "Old" },
                            { name: "Isaiah", chapters: 66, testament: "Old" },
                            { name: "Jeremiah", chapters: 52, testament: "Old" },
                            { name: "Lamentations", chapters: 5, testament: "Old" },
                            { name: "Ezekiel", chapters: 48, testament: "Old" },
                            { name: "Daniel", chapters: 12, testament: "Old" },
                            { name: "Hosea", chapters: 14, testament: "Old" },
                            { name: "Joel", chapters: 3, testament: "Old" },
                            { name: "Amos", chapters: 9, testament: "Old" },
                            { name: "Obadiah", chapters: 1, testament: "Old" },
                            { name: "Jonah", chapters: 4, testament: "Old" },
                            { name: "Micah", chapters: 7, testament: "Old" },
                            { name: "Nahum", chapters: 3, testament: "Old" },
                            { name: "Habakkuk", chapters: 3, testament: "Old" },
                            { name: "Zephaniah", chapters: 3, testament: "Old" },
                            { name: "Haggai", chapters: 2, testament: "Old" },
                            { name: "Zechariah", chapters: 14, testament: "Old" },
                            { name: "Malachi", chapters: 4, testament: "Old" },
                            { name: "Matthew", chapters: 28, testament: "New" },
                            { name: "Mark", chapters: 16, testament: "New" },
                            { name: "Luke", chapters: 24, testament: "New" },
                            { name: "John", chapters: 21, testament: "New" },
                            { name: "Acts", chapters: 28, testament: "New" },
                            { name: "Romans", chapters: 16, testament: "New" },
                            { name: "1 Corinthians", chapters: 16, testament: "New" },
                            { name: "2 Corinthians", chapters: 13, testament: "New" },
                            { name: "Galatians", chapters: 6, testament: "New" },
                            { name: "Ephesians", chapters: 6, testament: "New" },
                            { name: "Philippians", chapters: 4, testament: "New" },
                            { name: "Colossians", chapters: 4, testament: "New" },
                            { name: "1 Thessalonians", chapters: 5, testament: "New" },
                            { name: "2 Thessalonians", chapters: 3, testament: "New" },
                            { name: "1 Timothy", chapters: 6, testament: "New" },
                            { name: "2 Timothy", chapters: 4, testament: "New" },
                            { name: "Titus", chapters: 3, testament: "New" },
                            { name: "Philemon", chapters: 1, testament: "New" },
                            { name: "Hebrews", chapters: 13, testament: "New" },
                            { name: "James", chapters: 5, testament: "New" },
                            { name: "1 Peter", chapters: 5, testament: "New" },
                            { name: "2 Peter", chapters: 3, testament: "New" },
                            { name: "1 John", chapters: 5, testament: "New" },
                            { name: "2 John", chapters: 1, testament: "New" },
                            { name: "3 John", chapters: 1, testament: "New" },
                            { name: "Jude", chapters: 1, testament: "New" },
                            { name: "Revelation", chapters: 22, testament: "New" },
                        ];

                        const randomVerseElement = document.getElementById("randomVerseText");
                        const testamentSelect = document.getElementById("testamentSelect");
                        const bookSelect = document.getElementById("bookSelect");
                        const chapterSelect = document.getElementById("chapterSelect");
                        const verseSelect = document.getElementById("verseSelect");

                        // Populate books based on testament
                        function populateBooks() {
                            bookSelect.innerHTML = "<option value=''>Select Book</option>";
                            const selectedTestament = testamentSelect.value;
                            books.filter(book => book.testament === selectedTestament)
                                .forEach(book => {
                                    const option = document.createElement("option");
                                    option.value = book.name;
                                    option.textContent = book.name;
                                    bookSelect.appendChild(option);
                                });
                        }

                        function populateChapters() {
                            const selectedBook = books.find(book => book.name === bookSelect.value);
                            chapterSelect.innerHTML = "<option value=''>Select Chapter</option>";
                            if (selectedBook) {
                                for (let i = 1; i <= selectedBook.chapters; i++) {
                                    const option = document.createElement("option");
                                    option.value = i;
                                    option.textContent = i;
                                    chapterSelect.appendChild(option);
                                }
                            }
                        }

                        function populateVerses() {
                            verseSelect.innerHTML = "<option value=''>Select Verse</option>";
                            for (let i = 1; i <= 50; i++) {
                                const option = document.createElement("option");
                                option.value = i;
                                option.textContent = i;
                                verseSelect.appendChild(option);
                            }
                        }

                        // Fetch random verse of the day with date-based logic
                        async function fetchRandomVerse() {
                            try {
                                // Use current date to determine a new "random" verse each day
                                const today = new Date();
                                const dayOfYear = Math.floor((today - new Date(today.getFullYear(), 0, 0)) / 86400000);

                                // List of sample references to rotate through based on day of the year
                                const verses = ["John 3:16", "Psalm 23:1", "Genesis 1:1", "Romans 8:28", "Proverbs 3:5"];
                                const verseIndex = dayOfYear % verses.length;
                                const selectedVerse = verses[verseIndex];

                                // Fetch the selected verse
                                const response = await fetch(`https://bible-api.com/${selectedVerse}`);
                                const data = await response.json();

                                if (response.ok) {
                                    randomVerseElement.textContent = `${data.reference} - "${data.text}"`;
                                } else {
                                    randomVerseElement.textContent = "Error fetching random verse.";
                                }
                            } catch (error) {
                                randomVerseElement.textContent = "Error fetching random verse.";
                            }
                        }

                        // Initialize
                        fetchRandomVerse();


                        // Fetch verse
                        async function fetchVerse() {
                            const book = bookSelect.value;
                            const chapter = chapterSelect.value;
                            const verse = verseSelect.value;
                            const displayDiv = document.getElementById("verseDisplay");
                            displayDiv.innerHTML = "";

                            try {
                                const response = await fetch(`https://bible-api.com/${book} ${chapter}:${verse}`);
                                const data = await response.json();
                                if (response.ok) {
                                    displayDiv.innerHTML = `<h3>${data.reference}</h3><p>${data.text}</p><small>${data.translation_name}</small>`;
                                } else {
                                    displayDiv.textContent = "Verse not found.";
                                }
                            } catch (error) {
                                displayDiv.textContent = "Error fetching verse.";
                            }
                        }

                        // Fetch chapter
                        async function fetchChapter() {
                            const book = bookSelect.value;
                            const chapter = chapterSelect.value;
                            const displayDiv = document.getElementById("verseDisplay");
                            displayDiv.innerHTML = "";

                            try {
                                const response = await fetch(`https://bible-api.com/${book} ${chapter}`);
                                const data = await response.json();
                                if (response.ok) {
                                    displayDiv.innerHTML = `<h3>${data.reference}</h3><p>${data.text}</p><small>${data.translation_name}</small>`;
                                } else {
                                    displayDiv.textContent = "Chapter not found.";
                                }
                            } catch (error) {
                                displayDiv.textContent = "Error fetching chapter.";
                            }
                        }

                        // Fetch entire book
                        async function fetchBook() {
                            const book = bookSelect.value;
                            const displayDiv = document.getElementById("verseDisplay");
                            displayDiv.innerHTML = "";

                            try {
                                const response = await fetch(`https://bible-api.com/${book}`);
                                const data = await response.json();
                                if (response.ok) {
                                    displayDiv.innerHTML = `<h3>${data.reference}</h3><p>${data.text}</p><small>${data.translation_name}</small>`;
                                } else {
                                    displayDiv.textContent = "Book not found.";
                                }
                            } catch (error) {
                                displayDiv.textContent = "Error fetching book.";
                            }
                        }

                        // Initialize
                        fetchRandomVerse();
                    </script>
								</div>

                            <div class="block-content collapse in">
                                <div class="span12">
										<?php include('teacher_class.php'); ?>
                                </div>

                            </div>
                        </div>
                        <!-- /block -->
                    </div>
									<script type="text/javascript">
									$(document).ready( function() {
										$('.remove').click( function() {
										var id = $(this).attr("id");
											$.ajax({
											type: "POST",
											url: "delete_class.php",
											data: ({id: id}),
											cache: false,
											success: function(html){
											$("#del"+id).fadeOut('slow', function(){ $(this).remove();}); 
											$('#'+id).modal('hide');
											$.jGrowl("Your Class is Successfully Deleted", { header: 'Class Delete' });
											}
											}); 	
											return false;
										});				
									});
									</script>
                </div>
				<?php include('teacher_right_sidebar.php') ?>
            </div>
		<?php include('footer.php'); ?>
        </div>
		<?php include('script.php'); ?>
    </body>
</html>