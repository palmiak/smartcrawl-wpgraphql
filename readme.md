# WPGraphQL Extension for SmartCrawl

## Requirements
To use this plugin you'll need:
- [WPGraphQL](https://github.com/wp-graphql/wp-graphql) - 🚀 GraphQL API for WordPress
- [SmartCrawl](https://wordpress.org/plugins/smartcrawl-seo/) or [SmartCrawl PRO](https://premium.wpmudev.org/project/smartcrawl-wordpress-seo/) - WordPress SEO checker, analyzer, and optimizer

## Usage
For posts and post types:
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
          twitterDescription
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

For taxonomies:
```graphql
query GET_CATEGORIES {
  categories {
    edges {
      node {
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
          twitterDescription
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

## Contributions
Big thanks to [Ashley Hitchcock](https://github.com/ashhitch) for inspiration.
