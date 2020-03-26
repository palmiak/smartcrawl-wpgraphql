# WPGraphQL Extension for SmartCrawl

## Requirements
To use this plugin you'll need:
- [WPGraphQL](https://github.com/wp-graphql/wp-graphql) - 🚀 GraphQL API for WordPress
- [SmartCrawl](https://wordpress.org/plugins/smartcrawl-seo/) or [SmartCrawl PRO](https://premium.wpmudev.org/project/smartcrawl-wordpress-seo/) - WordPress SEO checker, analyzer, and optimizer

## Usage
```graphql
query GET_POSTS {
  posts {
    edges {
      node {
        id
        title
        date
       	smartcrawl_seo{
          title
          metaDesc
          metaRobotsNoindex
          metaRobotsNofollow
          opengraphTitle
          opengraphDescription
          canonical
          opengraphImage {
            sourceUrl
          }
          twitterTitle
          twitterImage {
            sourceUrl
          }
          twitterCard
          focusKeywords
        }
      }
    }
  }
}
```

## Notes
It's not production ready yet, but if you're brave enough - give it a try :)

This plugin is under development yet and some features are missing.
