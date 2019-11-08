function Person(firstname, lastname, age, hobbies) {
	this.name = {
		firstname,
		lastname
	};

	this.age = age;
	this.hobbies = hobbies;
}

Person.prototype.getAge = function() {
	return this.age;
};

Person.prototype.sayName = function() {
	console.log("My name is " + this.name.firstname + ", " + this.name.lastname);
};

function Programmer(first, last, age, hobbies, language) {
	Person.call(this, first, last, age, hobbies);
	this.language = language;
}

Programmer.prototype = Object.create(Person.prototype);
Programmer.prototype.code = function() {
	console.log("Writing code in: " + this.language);
};

Object.defineProperty(Programmer.prototype, "constructor", {
	value: Programmer,
	enumerable: false,
	writable: true
});

var Jose = new Programmer(
	"Jose",
	"Ederango",
	19,
	["Coding", "Gaming", "Travel"],
	"Javascript"
);

Jose.hobbies.forEach(value => console.log(value))
