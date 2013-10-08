var FiltersView = Marionette.CompositeView.extend({
    template: "#settings-filters",

    itemView: FilterItemView,
    itemViewContainer: '.filters'
});
